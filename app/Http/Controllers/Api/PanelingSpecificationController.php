<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecificationRequest;
use App\Http\Requests\UpdateSpecificationRequest;
use App\Http\Resources\SpecifcationResource;
use App\Models\PanelingSpecification;
use App\Trait\JsonResponsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PanelingSpecificationController extends Controller
{
    use JsonResponsable;
    public function index()
    {
        $specification = PanelingSpecification::all();
        if($specification->isEmpty())
        {
            return $this->success(200,[],__("No data found"));
        }
        return $this->success(200,SpecifcationResource::collection($specification));
    }
    public function store(SpecificationRequest $request)
    {
        $data = $request->validated();
        $specification = PanelingSpecification::create($data);
        if(!$specification)
        {
            return $this->success(200,[],__("No data found"));
        }
        return $this->success(200,$specification,__("Data created successfuly"));
    }
    public function update(UpdateSpecificationRequest $request, $id)
    {
        $data = $request->validated();
        try{
            $specification = PanelingSpecification::findOrFail($id);
            $specification->update($data);
            return $this->success(200,new SpecifcationResource($specification),__("Data updated successfuly"));
        }catch(ModelNotFoundException $e){
            return $this->success(200,[],__("No data found"));
        }
    }
    public function show($id)
    {
        try{
            $specification = PanelingSpecification::findOrFail($id);
            return $this->success(200,new SpecifcationResource($specification));
        }catch(ModelNotFoundException $e)
        {
            return $this->success(200,[],__("No data found"));
        }
    }
    public function destroy($id)
    {
        try{
            $specification = PanelingSpecification::findOrFail($id);
            $specification->delete();
            return $this->success(200,__("Data deleted successfuly"));
        }catch(ModelNotFoundException $e)
        {
            return $this->success(200,[],__("No data found"));
        }
    }
}
