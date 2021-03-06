<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Post
 *
 * @package App
 * @property string $event
 * @property string $author
 * @property text $body
*/
class Post extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;


    protected $fillable = ['body', 'notifi','group_id', 'author_id'];
    protected $appends = ['gallery', 'gallery_link', 'uploaded_gallery','comments_count','likes_count'];
    protected $with = ['media','author','comments','likes'];


    public static function storeValidation($request)
    {
        return [
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'body' => 'max:65535|nullable',
            'gallery' => 'nullable',
            'gallery.*' => 'file|image|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'body' => 'max:65535|nullable',
            'gallery' => 'sometimes',
            'gallery.*' => 'file|image|nullable'
        ];
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
    public function getGalleryAttribute()
    {
        return [];
    }

    public function getUploadedGalleryAttribute()
    {
        return $this->getMedia('gallery')->keyBy('id');
    }

    /**
     * @return string
     */
    public function getGalleryLinkAttribute()
    {
        $gallery = $this->getMedia('gallery');
        if (! count($gallery)) {
            return null;
        }
        $html = [];
        foreach ($gallery as $file) {
            $html[] = '<img src="'.url($file->getUrl()).'">';
        }

        return implode('<br/>', $html);
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id')->withTrashed();
    }

    public function read_by()
    {
        return $this->belongsToMany(User::class,'read_status','post_id','author_id');
    }

    public function notifi_by()
    {
        return $this->belongsToMany(User::class,'notifi_status','post_id','author_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeOfGroup($query,$group)
    {

        return   $query->whereHas('group', function ($query) use ( $group)
					{  $query->where('groups.id',$group);});

    }


}
