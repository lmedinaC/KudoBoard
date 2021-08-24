<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    use SoftDeletes;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'publications';


    /**
     * Attributes of the table
     *
     */
    protected $fillable = [ 
        'guest_id',
        'description',
    ];


    
     /**
     * Relation one to many (inverse) District
     *
     */
    public function guest(){
        return $this->belongsTo('App\Guest', 'guest_id');
    }
}
