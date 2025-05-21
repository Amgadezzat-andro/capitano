<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreColorRequest;
use App\Http\Requests\UpdateColorRequest;
use App\Models\Color;
use App\Trait\JsonResponsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    use JsonResponsable;
    public function index()
    {
        $colors = Color::all();
        if($colors->isEmpty())
        {
            return $this->success(200,[],__("No data found"));
        }
        return $this->success(200,$colors);
    }
    public function store(StoreColorRequest $request)
    {
        $data = $request->validated();
        $color=Color::create($data);
        return $this->success(200,$color,__("Data created successfuly"));
    }
    public function update(UpdateColorRequest $request, $id)
    {
        $data = $request->validated();
        try{
            $color = Color::findOrFail($id);
            $color->update($data);
            return $this->success(200,$color,__("Data updated successfuly"));
        }catch(ModelNotFoundException $e)
        {
            return $this->success(200,[],__("No data found"));
        }
        
    }
    public function show($id)
    {
        try{
            $color = Color::findOrFail($id);
            return $this->success(200,$color);
        }catch(ModelNotFoundException $e)
        {
            return $this->success(200,[],__("No data found"));
        }
    }
    public function destroy($id)
    {
        try{
            $color = Color::findOrFail($id);
            $color->delete();
            return $this->success(200,[],__("Data deleted successfuly"));
        }catch(ModelNotFoundException $e){
            return $this->success(200,[],__("No data found"));
        }
    }
}
