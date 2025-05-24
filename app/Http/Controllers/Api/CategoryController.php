<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Rules\NotNumbersOnly;
use App\Trait\JsonResponsable;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use JsonResponsable;
    public function index()
    {

        $categories = Category::all();

        if ($categories->isEmpty()){
            return $this->success(200,[], __("No data found"));
        }
        return $this->success(200, data: $categories);
    }
    public function store(StoreCategoryRequest $request)
    {
        $data=$request->validated();
        if($request->hasFile('image'))
        {
            $data['image'] = uploadImage($request->file('image'),"Categories");
        }
        $categories=Category::create($data);
        return $this->success(200,$categories,__("Data created successfuly"));
    }
    public function show( $catId)
    {
        try{
            $cat= Category::findOrFail($catId);

            return $this->success(200,data:$cat);
        }catch(ModelNotFoundException $e){
            return $this->success(200,[],__("No data found"));
        }
    }
    public function update(Request $request , $catID)
    {
        try{
        $cat= Category::findOrFail($catID);
        $data=$request->validate([
            'name'=>['required','string',new NotNumbersOnly(),"unique:categories,name,$cat->id"],
            'image'=>['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'status'=>['integer','in:0,1']
        ]);
        $data['image']=$this->updateImage($cat->image);
        $cat->update($data);
        return $this->success(200,data:$cat,message:__("Data updated successfuly"));

    }catch(ModelNotFoundException $e)
    {return $this->success(200,[],__("No data found"));}

    }

    public  function updateImage($imageName)
    {
        if (request()->hasFile('image')) {
            deleteImage($imageName, "Categories");
            return uploadImage(request()->file('image'), "Categories");
        } else {
            return $imageName;
        }
    }

    public function destroy($id)
    {
        try{

            $cat = Category::findOrFail($id);
            $cat->delete();
            return $this->success(200,[],__("Data deleted successfuly"));
        }catch(ModelNotFoundException $e)
            {return $this->success(200,[],__("No data found"));}
    }
    // get all categories for website
    public function getAllCat()
    {
        $cats = Category::whereStatus(true)->get();
         if ($cats->isEmpty())
         {
            return $this->success(200,[],__("No data found"));
         }
        //  $result = $cats->map(function($cat){
        //     return [
        //         'id'=>$cat->id,
        //         'name'=>$cat->name,
        //         'image'=>getImagePathFromDirectory($cat->image,'Categories')
        //     ];
        //  }) ;
         return $this->success(200,data:$cats);
    }

}
