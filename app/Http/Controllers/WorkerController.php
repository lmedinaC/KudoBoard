<?php

namespace App\Http\Controllers;

use App\Worker;
use App\Http\Requests\AttributeCustumerRequest;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\DeleteCustomerRequest;
use App\Http\Requests\RestoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
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
        $customers = CustomerResource::collection(Customer::all());
        return $customers;
    }

    

   
}