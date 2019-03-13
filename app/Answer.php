<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Answer
 *
 * @package App
 * @property string $session
 * @property string $question
 * @property string $author
 * @property text $text
*/
class Answer extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['text', 'session_id', 'question_id', 'author_id'];
    

    public static function storeValidation($request)
    {
        return [
            'session_id' => 'integer|exists:sessions,id|max:4294967295|required',
            'question_id' => 'integer|exists:answers,id|max:4294967295|nullable',
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'text' => 'max:65535|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'session_id' => 'integer|exists:sessions,id|max:4294967295|required',
            'question_id' => 'integer|exists:answers,id|max:4294967295|nullable',
            'author_id' => 'integer|exists:users,id|max:4294967295|required',
            'text' => 'max:65535|required'
        ];
    }

    

    
    
    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id')->withTrashed();
    }
    
    public function question()
    {
        return $this->belongsTo(Answer::class, 'question_id')->withTrashed();
    }
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    
}
