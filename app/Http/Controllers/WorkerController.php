<?php

namespace App\Http\Controllers;

use App\Worker;
use App\Http\Resources\WorkerResource;
use Attribute;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\FunctionUnit;

class WorkerController extends Controller
{

    /**
     * All Customer Getter with custom Data
     */
    public function getAll()
    {
        $workers = WorkerResource::collection(Worker::all());
        return $workers;
    }

    

   
}