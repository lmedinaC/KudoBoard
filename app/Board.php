<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'boards';


    /**
     * Attributes of the table
     *
     */
    protected $fillable = [ 
        'description',
        'start_date',
        'end_date',
        'num_max_guest',
        'owner_id',
    ];


    /**
     * Relation one to many Guest
     *
     */
    public function guests(){
        return $this->hasMany('App\Guest');
    }

    /**
     * Relation one to many Recipient
     *
     */
    public function recipients(){
        return $this->hasMany('App\Recipient');
    }

     /**
     * Relation one to many (inverse) District
     *
     */
    public function worker(){
        return $this->belongsTo('App\Worker', 'owner_id');
    }
}
