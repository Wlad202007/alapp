<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    //
	  protected $table = 'session_user';

    protected $fillable = ['session_id', 'user_id','status'];
 /**
     * Set attribute to money format
     * @param $input
     */
    public function setSessionIdAttribute($input)
    {
        $this->attributes['account_id'] = $input ? $input : null;
    }

	  /**
     * Set to null if empty
     * @param $input
     */
     public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = $input ? $input : null;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
	 public function session()
    {
        return $this->belongsTo(User::class, 'session_id');
    }
	public function scopeYes($query)
    {
        return $query->where('status','=','Yes');
		
		
    }
	public function scopeNo($query)
    {
        return $query->where('suma','=','No');
		
		
    }
	
	
	
}
