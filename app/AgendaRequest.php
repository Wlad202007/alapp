<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 *
 * @package App
 * @property string $event
 * @property string $author
 * @property text $body
*/
class AgendaRequest extends Model
{
    protected $table = 'agenda_request';
    protected $fillable = ['event_id', 'user_id'];
    // protected $appends = ['gallery', 'gallery_link', 'uploaded_gallery','comments_count','likes_count'];
    // protected $with = ['media','author','comments','likes'];
    public function events()
    {
        return $this->belongsTo(Event::class,'event_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


}
