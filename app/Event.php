<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Event
 *
 * @package App
 * @property string $name
 * @property text $description
 * @property string $date_from
 * @property string $date_to
 * @property string $full_agenda
 * @property string $web_url
 * @property string $industry
*/
class Event extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    
    protected $fillable = ['name', 'description', 'address', 'date_from', 'date_to', 'web_url', 'industry_id'];
    protected $appends = ['full_agenda', 'full_agenda_link', 'my_event', 'liked', 'interested'];
    protected $with = ['media'];
    

    public static function storeValidation($request)
    {
        return [
            'name' => 'max:191|required',
            'address' => 'max:250|required',
            'description' => 'max:65535|nullable',
            'date_from' => 'date_format:' . config('app.date_format') . '|max:191|nullable',
            'date_to' => 'date_format:' . config('app.date_format') . '|max:191|nullable',
            'full_agenda' => 'file|nullable',
            'web_url' => 'max:191|nullable',
            'attendees' => 'array|nullable',
            'attendees.*' => 'integer|exists:users,id|max:4294967295|nullable',
            'sponsors' => 'array|nullable',
            'sponsors.*' => 'integer|exists:sponsors,id|max:4294967295|nullable',
            'agenda' => 'array|nullable',
            'agenda.*' => 'integer|exists:agendas,id|max:4294967295|nullable',
            'industry_id' => 'integer|exists:industries,id|max:4294967295|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'name' => 'max:191|required',
            'address' => 'max:250|required',
            'description' => 'max:65535|nullable',
            'date_from' => 'date_format:' . config('app.date_format') . '|max:191|nullable',
            'date_to' => 'date_format:' . config('app.date_format') . '|max:191|nullable',
            'full_agenda' => 'nullable',
            'web_url' => 'max:191|nullable',
            'attendees' => 'array|nullable',
            'attendees.*' => 'integer|exists:users,id|max:4294967295|nullable',
            'sponsors' => 'array|nullable',
            'sponsors.*' => 'integer|exists:sponsors,id|max:4294967295|nullable',
            'agenda' => 'array|nullable',
            'agenda.*' => 'integer|exists:agendas,id|max:4294967295|nullable',
            'industry_id' => 'integer|exists:industries,id|max:4294967295|nullable'
        ];
    }

    

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setDateFromAttribute($input)
    {
        if ($input) {
            $this->attributes['date_from'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        }
    }

    /**
     * Get attribute from date format
     * @param $output
     *
     * @return string
     */
    public function getDateFromAttribute($output)
    {
        if ($output) {
            return Carbon::createFromFormat('Y-m-d', $output)->format(config('app.date_format'));
        }
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setDateToAttribute($input)
    {
        if ($input) {
            $this->attributes['date_to'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        }
    }

    /**
     * Get attribute from date format
     * @param $output
     *
     * @return string
     */
    public function getDateToAttribute($output)
    {
        if ($output) {
            return Carbon::createFromFormat('Y-m-d', $output)->format(config('app.date_format'));
        }
    }

    public function getFullAgendaAttribute()
    {
        return $this->getFirstMedia('full_agenda');
    }

    /**
     * @return string
     */
    public function getFullAgendaLinkAttribute()
    {
        $file = $this->getFirstMedia('full_agenda');
        if (! $file) {
            return null;
        }

        return '<a href="' . $file->getUrl() . '" target="_blank">' . $file->file_name . '</a>';
    }
    
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }
    
    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'event_sponsor');//->withTrashed();
    }
    
    public function agenda()
    {
        return $this->belongsToMany(Agenda::class, 'agenda_event');//->withTrashed();
    }
    
    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');//->withTrashed();
    }

    public function fav_users()
    {
        return $this->belongsToMany(User::class, 'fav_event_user', 'event_id', 'user_id');
    }

    public function agenda_requests()
    {
        return $this->belongsToMany(User::class, 'agenda_request', 'event_id', 'user_id');
    }

    public function getLikedAttribute()
    {

        return \Auth::user()->fav_events->contains($this->id)?true:false;
        // return $this->fav_users()->count();

    }

    public function getMyEventAttribute()
    {

        return \Auth::user()->my_events->contains($this->id)?true:false;
//        $attendees = \Auth::user()->my_events;
//        return $attendees;

//        return \Auth::user()->attendees->contains($this->id)?true:false;
        // return $this->fav_users()->count();

    }

    public function getInterestedAttribute()
    {
        return \Auth::user()->agenda_requests->contains($this->id)?true:false;
        // return $this->agenda_requests()->count();

    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'event_id');//->withTrashed();
    }
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'event_id')->orderBy('time', 'asc');
    }
    
	public function messages()
    {
        return $this->hasMany(Message::class, 'group_id');//->withTrashed();
    }
	      public function scopeOfUser($query,$user)
    { 
		
        return   $query->whereHas('attendees', function ($query) use ( $user) 
					{  $query->where('user_id',$user);});
		
    }
}
