<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment
 *
 * @package App
 * @property text $text
 * @property string $post
 * @property string $author
*/
class Comment extends Model
{
    use SoftDeletes;


    protected $fillable = ['text', 'post_id', 'author_id'];


    public static function storeValidation($request)
    {
        return [
            'text' => 'max:65535|required',
            'post_id' => 'integer|exists:posts,id|max:4294967295|required',
            'author_id' => 'integer|exists:users,id|max:4294967295|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'text' => 'max:65535|required',
            'post_id' => 'integer|exists:posts,id|max:4294967295|required',
            'author_id' => 'integer|exists:users,id|max:4294967295|required'
        ];
    }





    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id')->withTrashed();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


}
