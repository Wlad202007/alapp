<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Note
 *
 * @package App
 * @property string $author
 * @property string $text
*/
class Note extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['text', 'author_id'];
    

    public static function storeValidation($request)
    {
        return [
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'text' => 'max:191|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'text' => 'max:191|required'
        ];
    }

    

    
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
      public function scopeOfUser($query,$user)
    { 
		
        return   $query->whereHas('author', function ($query) use ( $user) 
					{  $query->where('author_id',$user);});
		
    }
}
