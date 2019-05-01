<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Group
 *
 * @package App
 * @property string $name
 * @property tinyInteger $status
 */
class Group extends Model
{
    use SoftDeletes;


    protected $fillable = ['name', 'status'];
    protected $with = ['posts'];
    protected $appends = ['if_joined','joined_count'];


    public static function storeValidation($request)
    {
        return [
            'name' => 'min:3|max:191|required',
            'status' => 'boolean|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'name' => 'min:3|max:191|required',
            'status' => 'boolean|required'
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'group_id');
    }


    public function joined()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
    }

    public function getJoinedCountAttribute()
    {
        return $this->joined()->count();
    }

    public function getIfJoinedAttribute()
    {
        $auth = \Auth::user();

        if($auth->joined->contains($this->id)){
            return true;
        } else {
            return false;
        }
    }

  public function scopeOfUser($query,$user)
    {

        return   $query->whereHas('joined', function ($query) use ( $user)
					{  $query->where('user_id',$user);});

    }

}
