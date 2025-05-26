<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePanelingRequest;
use App\Http\Requests\UpdatePanelingRequest;
use App\Models\Paneling;
use App\Trait\JsonResponsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PanelingController extends Controller
{
    use JsonResponsable;
    public function index()
    {
        $panelings = Paneling::all();

        if ($panelings->isEmpty()) {
            return $this->success(200, data: [], message: __("No data found"));
        }

        return $this->success(200, data: $panelings);

    }
    public function getProductByCatId($catId)
    {
        $panelings = Paneling::with('specifications')->where('category_id', $catId)->get();
        if ($panelings->isEmpty()) {
            return $this->success(code: 200, data: [], message: __("No data found"));
        }
        return $this->success(200, data: $panelings);

    }
    public function store(StorePanelingRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = uploadImage($request->file('image'), 'Panelings');
        }
        $paneling = Paneling::create($data);
        if (!$paneling)
            return $this->failure(500, __("enternal server error"));

        return $this->success(200, data: $paneling, message: __("Data created successfuly"));
    }

    public function show($id)
    {
        try {
            $paneling = Paneling::findOrFail($id);
            return $this->success(200, data: $paneling);
        } catch (ModelNotFoundException $e) {
            return $this->success(200, data: [], message: __("No data found"));
        }
    }

    public function update($id, UpdatePanelingRequest $request)
    {
        try {
            $paneling = Paneling::findOrFail($id);
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = $this->updateImage($paneling->image);
            }


            $paneling->update($data);
            return $this->success(200, $paneling, __("Data created successfuly"));

        } catch (ModelNotFoundException $e) {

            return $this->success(200, data: [], message: __("No data found"));
        }
    }
    public function destroy($id)
    {
        try {
            $paneling = Paneling::findOrFail($id);
            $paneling->delete();
            return $this->success(200, [], __("Data deleted successfuly"));
        } catch (ModelNotFoundException $e) {
            return $this->success(200, data: [], message: __("No data found"));
        }
    }
    public function updateImage($imageName)
    {
        if (request()->hasFile('image')) {
            deleteImage($imageName, "Panelings");
            return uploadImage(request()->file('image'), "Panelings");
        } else {
            return $imageName;
        }
    }
}
