<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workers';


    /**
     * Attributes of the table
     *
     */
    protected $fillable = [ 
        'user_id',
    ];


    /**
     * Relation one to many Boards
     *
     */
    public function boards(){
        return $this->hasMany('App\Board');
    }

    /**
     * Relation one to many guests
     *
     */
    public function guests(){
        return $this->hasMany('App\Guest');
    }

    /**
     * Relation one to many recipients
     *
     */
    public function recipients(){
        return $this->hasMany('App\Recipient');
    }

     /**
     * Relation one to many (inverse) User
     *
     */
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

}
