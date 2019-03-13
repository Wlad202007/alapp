<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Like
 *
 * @package App
 * @property string $author
 * @property string $post
*/
class Like extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['author_id', 'post_id'];
    

    public static function storeValidation($request)
    {
        return [
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'post_id' => 'integer|exists:posts,id|max:4294967295|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'post_id' => 'integer|exists:posts,id|max:4294967295|required'
        ];
    }

    

    
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id')->withTrashed();
    }
    
    
}
