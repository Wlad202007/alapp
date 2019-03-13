<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Session
 *
 * @package App
 * @property string $user
 * @property string $presentation
 * @property string $event
 * @property text $description
 * @property string $subject
 * @property time $time_from
 * @property time $time_to
*/
class Session extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    
    protected $fillable = ['description', 'subject','question', 'time_from', 'time_to', 'user_id', 'event_id'];
    protected $appends = ['presentation', 'presentation_link', 'rate_content', 'rate_style'];
    protected $with = ['media','user'];
    

    public static function storeValidation($request)
    {
        return [
            'user_id' => 'integer|exists:users,id|max:4294967295|required',
            'presentation' => 'file|nullable',
            'event_id' => 'integer|exists:events,id|max:4294967295|required',
            'description' => 'max:65535|nullable',
            'subject' => 'max:191|required',
			 'question' => 'max:191',
            'time_from' => 'date_format:H:i|max:191|nullable',
            'time_to' => 'date_format:H:i|max:191|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'user_id' => 'integer|exists:users,id|max:4294967295|required',
            'presentation' => 'nullable',
            'event_id' => 'integer|exists:events,id|max:4294967295|required',
            'description' => 'max:65535|nullable',
            'subject' => 'max:191|required',
			 'question' => 'max:191',
            'time_from' => 'date_format:H:i|max:191|nullable',
            'time_to' => 'date_format:H:i|max:191|nullable'
        ];
    }

    

    public function getPresentationAttribute()
    {
        return $this->getFirstMedia('presentation');
    }

    /**
     * @return string
     */
    public function getPresentationLinkAttribute()
    {
        $file = $this->getFirstMedia('presentation');
        if (! $file) {
            return null;
        }

        return url($file->getUrl());
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withTrashed();
    }

    public function rates()
    {
        return $this->hasMany(Rate::class, 'session_id')->withTrashed();
    }
 
 
 public function questions()
    {
        return $this->belongsToMany(User::class, 'session_user')->withPivot('status');
    } 
	
	public function votes()
    {
        return $this->hasMany(Vote::class,'session_id');
    }
	
	
	
	

    public function getRateContentAttribute()
    {
        return $this->rates()->where('type','content')->avg('stars');
    }

    public function getRateStyleAttribute()
    {
        return $this->rates()->where('type','style')->avg('stars');
    }
      public function scopeOfUser($query,$user)
    { 
		
        return   $query->whereHas('user', function ($query) use ( $user) 
					{  $query->where('user_id',$user);});
		
    }
	
	      public function scopeVoteCount($query)
    { 
		        return   $query->withCount([ 
		'questions as votes_yes' => function ($query) { $query->where('status', 'yes');},
		'questions as votes_no' => function ($query) { $query->where('status', 'no');}
		
		]);
	}
}
