<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Models\Car;
use App\Trait\JsonResponsable;
use Illuminate\Http\Request;

class CarController extends Controller
{
    use JsonResponsable;
    public function index()
    {
        $cars= Car::all();
        if($cars->isEmpty())
        {
            return $this->failure(404,__("No data found"));
        }
        $result = $cars->map(function($car){
            return [
                'id'=>$car->id,
                'name'=>$car->name,
                'brand'=>$car->brand->name,
                'model'=>$car->model->name,
                'image'=>getImagePathFromDirectory($car->image,'Cars')
            ];
        });
        return $this->success(200,data:$result);
    }

    // public function store(StoreCarRequest $request)
    // {
    //     $data = $request->validated();
    //     if()
    // }
}
