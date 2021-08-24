<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use SoftDeletes;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'guests';


    /**
     * Attributes of the table
     *
     */
    protected $fillable = [ 
        'guest_id',
        'board_id',
    ];


    /**
     * Relation one to many publications
     *
     */
    public function publications(){
        return $this->hasMany('App\Publication');
    }

     /**
     * Relation one to many (inverse) District
     *
     */
    public function board(){
        return $this->belongsTo('App\Board', 'board_id');
    }
     /**
     * Relation one to many (inverse) District
     *
     */
    public function worker(){
        return $this->belongsTo('App\Worker', 'guest_id');
    }
}
