<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Sponsor
 *
 * @package App
 * @property string $name
 * @property string $description
 * @property string $website
 * @property string $logo
*/
class Sponsor extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    
    protected $fillable = ['name', 'description', 'website'];
    protected $appends = ['logo', 'logo_link'];
    protected $with = ['media'];
    

    public static function storeValidation($request)
    {
        return [
            'name' => 'max:191|required',
            'description' => 'max:191|nullable',
            'website' => 'max:191|nullable',
            'logo' => 'file|image|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'name' => 'max:191|required',
            'description' => 'max:191|nullable',
            'website' => 'max:191|nullable',
            'logo' => 'nullable'
        ];
    }

    

    public function getLogoAttribute()
    {
        return $this->getFirstMedia('logo');
    }

    /**
     * @return string
     */
    public function getLogoLinkAttribute()
    {
        $file = $this->getFirstMedia('logo');
        if (! $file) {
            return null;
        }

        return url($file->getUrl());
    }
     public function events()
    {
        return $this->belongsToMany(Event::class, 'event_sponsor')->withTrashed();
    }
    
	
	  public function scopeOfEvent($query,$event)
    { 
		
        return   $query->whereHas('events', function ($query) use ( $event) 
					{  $query->where('events.id',$event);});
		
    }
    
}
