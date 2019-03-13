<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Rate
 *
 * @package App
 * @property string $session
 * @property string $author
 * @property string $type
*/
class Rate extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['type', 'stars', 'session_id', 'author_id'];
    

    public static function storeValidation($request)
    {
        return [
            'session_id' => 'integer|exists:sessions,id|max:4294967295|required',
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'type' => 'in:style,content|max:191|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'session_id' => 'integer|exists:sessions,id|max:4294967295|required',
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'type' => 'in:style,content|max:191|required'
        ];
    }

    

    
    
    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id')->withTrashed();
    }
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    
}
