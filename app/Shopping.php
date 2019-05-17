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
class Shopping extends Model
{
    use SoftDeletes;


    protected $fillable = ['body', 'done', 'shoppinglist_id', 'author_id'];

    // public function setTimeAttribute($input)
    // {
    //     if ($input) {
    //         $this->attributes['time'] = Carbon::createFromFormat(config('app.date_format') . ' H:i:s', $input)->format('Y-m-d H:i:s');
    //     }
    // }
    public function shoppinglist()
    {
        return $this->belongsTo(ShoppingList::class, 'shoppinglist_id')->withTrashed();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


}
