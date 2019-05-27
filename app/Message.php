<?php
namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Message
 *
 * @package App
 * @property text $body
 * @property string $author
 * @property string $group
 * @property tinyInteger $read
*/
class Message extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;


    protected $fillable = ['body', 'read','notifi', 'author_id', 'friend_id', 'group_id'];
    protected $appends = ['time','attachments', 'attachments_link', 'uploaded_attachments'];
    protected $with = ['media','author','friend'];


    public static function storeValidation($request)
    {
        return [
            'body' => 'max:65535|nullable',
            'attachments' => 'nullable',
            'attachments.*' => 'file|nullable',
            'users' => 'array|nullable',
            'users.*' => 'integer|exists:users,id|max:4294967295|nullable',
            'author_id' => 'integer|exists:users,id|max:4294967295|nullable',
            'group_id' => 'integer|exists:events,id|max:4294967295|nullable',
            'read' => 'boolean|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'body' => 'max:65535|nullable',
            'attachments' => 'sometimes',
            'attachments.*' => 'file|nullable',
            'users' => 'array|nullable',
            'users.*' => 'integer|exists:users,id|max:4294967295|nullable',
            'author_id' => 'integer|exists:users,id|max:4294967295|nullable',
            'group_id' => 'integer|exists:events,id|max:4294967295|nullable',
            'read' => 'boolean|required'
        ];
    }

    public function getTimeAttribute()
    {
        return $this->created_at->format('H:i');
    }

    public function getAttachmentsAttribute()
    {
        return [];
    }

    public function getUploadedAttachmentsAttribute()
    {
        return $this->getMedia('attachments')->keyBy('id');
    }

    /**
     * @return string
     */
    public function getAttachmentsLinkAttribute()
    {
        $attachments = $this->getMedia('attachments');
        if (! count($attachments)) {
            return null;
        }
        $html = [];
        foreach ($attachments as $file) {
            $html[] = '<a href="' . $file->getUrl() . '" target="_blank">' . $file->file_name . '</a>';
        }

        return implode('<br/>', $html);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'message_user');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    public function group()
    {
        return $this->belongsTo(Event::class, 'group_id')->withTrashed();
    }


}
