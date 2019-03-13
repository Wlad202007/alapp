<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Agenda
 *
 * @package App
 * @property string $event
 * @property time $time
 * @property string $text
*/
class Agenda extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['time', 'date', 'label', 'text', 'event_id'];
    

    public static function storeValidation($request)
    {
        return [
            'event_id' => 'integer|exists:events,id|max:4294967295|required',
            'time' => 'date_format:H:i|max:191|required',
            'label' => 'required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'event_id' => 'integer|exists:events,id|max:4294967295|required',
            'time' => 'date_format:H:i|max:191|required',
            'label' => 'required'
        ];
    }


    public function setDateAttribute($input)
    {
        if ($input) {
            $this->attributes['date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        }
    }

    public function getDateAttribute($output)
    {
        if ($output) {
            return Carbon::createFromFormat('Y-m-d', $output)->format(config('app.date_format'));
        }
    }
    
    
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withTrashed();
    }
    
    
}
