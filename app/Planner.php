<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Planner
 *
 * @package App
 * @property string $time
 * @property text $body
 * @property tinyInteger $done
 * @property string $author
*/
class Planner extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['time', 'body', 'done', 'author_id'];
    protected $appends = ['short_time'];


    public static function storeValidation($request)
    {
        return [
//            'time' => 'date_format:' . config('app.date_format') . ' H:i:s|max:191|required',
//            'users' => 'array|nullable',
//            'users.*' => 'integer|exists:users,id|max:4294967295|nullable',
//            'body' => 'max:65535|nullable',
//            'done' => 'boolean|required',
//            'author_id' => 'integer|exists:users,id|max:4294967295|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'time' => 'date_format:' . config('app.date_format') . ' H:i:s|max:191|required',
            'users' => 'array|nullable',
            'users.*' => 'integer|exists:users,id|max:4294967295|nullable',
            'body' => 'max:65535|nullable',
            'done' => 'boolean|required',
            'author_id' => 'integer|exists:users,id|max:4294967295|nullable'
        ];
    }

    

    /**
     * Set attribute to datetime format
     * @param $input
     */
    public function setTimeAttribute($input)
    {
        if ($input) {
            $this->attributes['time'] = Carbon::createFromFormat(config('app.date_format') . ' H:i:s', $input)->format('Y-m-d H:i:s');
        }
    }


    public function getShortTimeAttribute()
    {
       return Carbon::parse($this->time)->format('h:s');
    }

    /**
     * Get attribute from datetime format
     * @param $output
     *
     * @return string
     */
    public function getTimeAttribute($output)
    {
        if ($output) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $output)->format(config('app.date_format') . ' H:i:s');
        }
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'planner_user');
    }
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
          public function scopeOfUser($query,$user)
    { 
		
        return   $query->whereHas('users', function ($query) use ( $user) 
					{  $query->where('user_id',$user);});
		
    }
}
