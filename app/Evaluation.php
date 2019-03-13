<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Evaluation
 *
 * @package App
 * @property string $user
 * @property string $event
 * @property text $text
*/
class Evaluation extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['text', 'user_id', 'event_id'];
    protected $casts = [
        'text' => 'object'
    ];


    public static function storeValidation($request)
    {
        return [
            'user_id' => 'integer|exists:users,id|max:4294967295|nullable',
            'event_id' => 'integer|exists:events,id|max:4294967295|nullable',
            'text' => 'max:65535|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'user_id' => 'integer|exists:users,id|max:4294967295|nullable',
            'event_id' => 'integer|exists:events,id|max:4294967295|nullable',
            'text' => 'max:65535|nullable'
        ];
    }

    

    
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withTrashed();
    }
    
    
}
