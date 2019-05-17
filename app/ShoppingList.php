<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Spatie\MediaLibrary\HasMedia\HasMedia;
//use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Post
 *
 * @package App
 * @property string $event
 * @property string $author
 * @property text $body
*/
class ShoppingList extends Model
{
    use SoftDeletes;


    protected $fillable = ['body', 'author_id'];
    //protected $appends = ['gallery', 'gallery_link', 'uploaded_gallery','comments_count','likes_count'];
    protected $with = ['author','shoppings'];


    // public static function storeValidation($request)
    // {
    //     return [
    //         'author_id' => 'integer|exists:users,id|max:4294967295|required',
    //         'body' => 'max:65535|nullable',
    //         'gallery' => 'nullable',
    //         'gallery.*' => 'file|image|nullable'
    //     ];
    // }
    //
    // public static function updateValidation($request)
    // {
    //     return [
    //         'author_id' => 'integer|exists:users,id|max:4294967295|required',
    //         'body' => 'max:65535|nullable',
    //         'gallery' => 'sometimes',
    //         'gallery.*' => 'file|image|nullable'
    //     ];
    // }

    public function shoppings()
    {
        return $this->hasMany(Shopping::class, 'shoppinglist_id');
    }
    public function getShoppingsCountAttribute()
    {
        return $this->shopings()->count();
    }
    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'shopping_lists_user');
    // }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    // public function scopeOfUser($query,$user)
    // {
    //   return   $query->whereHas('users', function ($query) use ( $user)
    //     {  $query->where('user_id',$user);});
    // }

}
