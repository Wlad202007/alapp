<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword;
use Hash;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 *
 * @package App
 * @property string $avatar
 * @property string $name
 * @property text $description
 * @property string $company
 * @property string $job
 * @property string $phone
 * @property string $email
 * @property string $password
 * @property string $remember_token
*/
class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasMediaTrait, HasApiTokens;

    
    protected $fillable = ['name', 'description', 'company', 'job', 'phone', 'email', 'password', 'remember_token'];
    protected $hidden = ['password', 'remember_token'];
    protected $appends = ['avatar', 'avatar_link', 'rate'];
    protected $with = ['media'];

    public static function storeValidation($request)
    {
        return [
            'avatar' => 'file|image|nullable',
            'name' => 'max:191|required',
            'description' => 'max:65535|nullable',
            'company' => 'max:191|nullable',
            'job' => 'max:191|nullable',
            'phone' => 'max:191|nullable',
            'email' => 'email|max:191|required|unique:users,email',
            'password' => 'required',
            'role' => 'array|required',
            'role.*' => 'integer|exists:roles,id|max:4294967295|required',
            'remember_token' => 'max:191|nullable',
            'my_events' => 'array|nullable',
            'my_events.*' => 'integer|exists:events,id|max:4294967295|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'avatar' => 'nullable',
            'name' => 'max:191|required',
            'description' => 'max:65535|nullable',
            'company' => 'max:191|nullable',
            'job' => 'max:191|nullable',
            'phone' => 'max:191|nullable',
            'email' => 'email|max:191|required|unique:users,email,'.$request->route('user'),
            'password' => '',
            'role' => 'array|required',
            'role.*' => 'integer|exists:roles,id|max:4294967295|required',
            'remember_token' => 'max:191|nullable',
            'my_events' => 'array|nullable',
            'my_events.*' => 'integer|exists:events,id|max:4294967295|nullable'
        ];
    }

    public function getAvatarAttribute()
    {
        return $this->getFirstMedia('avatar');
    }

    /**
     * @return string
     */
    public function getAvatarLinkAttribute()
    {

        $files = $this->getMedia('avatar');

        $file = $this->getFirstMedia('avatar');

//        dd($files->count(), $file);

        if (! $file) {
            return null;
        }

        return url($files[$files->count()-1]->getUrl());
    }

    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    
    public function my_events()
    {
        return $this->belongsToMany(Event::class, 'event_user', 'user_id', 'event_id')->orderBy('created_at', 'desc');
    }

    public function fav_events()
    {
        return $this->belongsToMany(Event::class, 'fav_event_user', 'user_id', 'event_id')->orderBy('created_at', 'desc');
    }

    public function joined()
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id');
    }

    public function agenda_requests()
    {
        return $this->belongsToMany(Event::class, 'agenda_request', 'user_id', 'event_id');
    }

    public function user_likes()
    {
        return $this->hasMany(UsersLike::class, 'user_id');
    }
 public function sessions()
    {
        return $this->hasMany(Session::class, 'user_id');
    }
    public function getRateAttribute()
    {
        return $this->user_likes()->avg('text');
    }

    public function myMessages()
    {
        return $this->hasMany(Message::class, 'author_id')->orderBy('created_at', 'desc');
    }

    public function friendsMessages()
    {
        return $this->hasMany(Message::class, 'friend_id')->distinct('friend_id');
    }

	 public function planners()
    {
        return $this->belongsToMany(Planner::class, 'planner_user', 'user_id', 'planner_id');
    }
	
	
    public function getAllMessagesAttribute($value)
    {
        $competitionsHome = $this->myMessages;
        $competitionsGuest = $this->friendsMessages;

        return $competitionsHome->merge($competitionsGuest);
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'message_user');
    }

    public function chats()
    {
        return $this->hasManyThrough(User::class, Message::class);
    }

    public function sendPasswordResetNotification($token)
    {
       $this->notify(new ResetPassword($token));
    }
	
	 public function notes()
    {
        return $this->hasMany(Note::class, 'author_id');
    }

	 public function questions()
    {
        return $this->belongsToMany(Session::class, 'session_user', 'user_id', 'session_id')->withPivot('status');
    } 
	
	public function votes()
    {
        return $this->hasMany(Vote::class,'user_id');
    }
	
	
	  public function scopeOfGroup($query,$group)
    { 
		
        return   $query->whereHas('joined', function ($query) use ( $group) 
					{  $query->where('group_id',$group);});
		
    }
}
