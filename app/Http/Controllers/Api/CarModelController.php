<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarModelRequest;
use App\Http\Requests\UpdateCarModelRequest;
use App\Http\Resources\ModelResource;
use App\Models\CarModel;
use App\Trait\JsonResponsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    use JsonResponsable;
    public function index()
    {
        $models = CarModel::all();
        if ($models->isEmpty()) {
            return $this->success(200, [], __("No data found"));
        }

        return $this->success(200, ModelResource::collection($models));
    }
    public function store(StoreCarModelRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image_start_year')) {
            $data['image_start_year'] = uploadImage($request->file('image_start_year'), 'Models');
        }
        if ($request->hasFile('image_end_year')) {
            $data['image_end_year'] = uploadImage($request->file('image_end_year'), 'Models');
        }
        $model = CarModel::create($data);
        return $this->success(200, data: new ModelResource($model), message: __("Data created successfuly"));
    }
    public function show($modelId)
    {
        try {
            $model = CarModel::findOrFail($modelId);
            return $this->success(200, data: new ModelResource($model));
        } catch (ModelNotFoundException $e) {
            return $this->success(200, [], __("No data found"));
        }
    }
    public function update(UpdateCarModelRequest $request, $id)
    {
        $data = $request->validated();
        // var_dump($request->all());
        // die;

        try {
            $model = CarModel::findOrFail($id);
            if ($request->hasFile('image_start_year')) {
                $data['image_start_year'] = $this->updateImage($model->image_start_year, 'image_start_year');
            }
            if ($request->hasFile('image_end_year')) {
                $data['image_end_year'] = $this->updateImage($model->image_end_year, 'image_end_year');
            }
            $model->update($data);

            return $this->success(code: 200, data: new ModelResource($model), message: __("Data updated successfuly"));
        } catch (ModelNotFoundException $e) {
            return $this->success(200, [], __("No data found"));
        }
    }

    public function destroy($id)
    {
        try {
            $model = CarModel::findOrFail($id);
            $model->delete();
            return $this->success(200, [], __("Data deleted successfuly"));
        } catch (ModelNotFoundException $e) {
            return $this->success(200, [], __("No data found"));
        }
    }
    //for website
    public function getAllModels()
    {
        $models = CarModel::whereStatus(true)->get();
        if ($models->isEmpty()) {
            return $this->success(200, [], __("No data found"));
        }

        return $this->success(200, ModelResource::collection($models));
    }
    public function updateImage($imageName, $field)
    {
        if (request()->hasFile($field)) {
            deleteImage($imageName, "Models");
            return uploadImage(request()->file($field), "Models");
        }

        return $imageName;
    }
}
