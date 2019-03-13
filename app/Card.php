<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Card
 *
 * @package App
 * @property string $author
 * @property text $body
 * @property string $img
*/
class Card extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    
    protected $fillable = ['body', 'author_id'];
    protected $appends = ['img', 'img_link'];
    protected $with = ['media'];
    

    public static function storeValidation($request)
    {
        return [
            'author_id' => 'integer|exists:users,id|max:4294967295|nullable',
            'body' => 'max:65535|nullable',
            'img' => 'file|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'author_id' => 'integer|exists:users,id|max:4294967295|nullable',
            'body' => 'max:65535|nullable',
            'img' => 'nullable'
        ];
    }

    

    public function getImgAttribute()
    {
        return $this->getFirstMedia('img');
    }

    /**
     * @return string
     */
    public function getImgLinkAttribute()
    {
        $file = $this->getFirstMedia('img');
        if (! $file) {
            return null;
        }

        return url($file->getUrl());
    }
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    
}
