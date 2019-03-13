<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UsersLike
 *
 * @package App
 * @property string $author
 * @property string $user
 * @property text $text
*/
class UsersLike extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['text', 'author_id', 'user_id'];
    

    public static function storeValidation($request)
    {
        return [
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'user_id' => 'integer|exists:users,id|max:4294967295|required',
            'text' => 'max:65535|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'user_id' => 'integer|exists:users,id|max:4294967295|required',
            'text' => 'max:65535|nullable'
        ];
    }

    

    
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    
}
