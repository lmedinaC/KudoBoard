<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipient extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recipients';


    /**
     * Attributes of the table
     *
     */
    protected $fillable = [ 
        'recipient_id',
        'board_id',
    ];


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
        return $this->belongsTo('App\Worker', 'recipient_id');
    }
}
