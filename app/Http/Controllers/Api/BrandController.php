<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Rules\NotNumbersOnly;
use App\Trait\JsonResponsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use JsonResponsable;
     // Get all brands
     public function index()
     {
         $brands = Brand::all();
         
         if($brands->isEmpty()) return $this->success(200,[],__("No data found"));
         return $this->success(200,data:$brands);
     }
 
     // Store a new brand
     public function store(Request $request)
     {
        $data= $request->validate([
            'name'=>['required','unique:brands,name','string',new NotNumbersOnly()],
             'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
         if($request->hasFile('image'))
         {
             $data['image'] = uploadImage($request->file('image'),"Brands");
         }
         $brand = Brand::create($data);
        
         return $this->success(200,$brand,message:__("Data created successfuly"));
     }
 
     // Show a specific brand
     public function show($id)
     {
       try{
         $brand = Brand::findOrFail($id);
        
         return $this->success(200,data:$brand);

        }catch(ModelNotFoundException $e)
            {
                return $this->success(200,[],__("No data found"));
            }
     }
 
     // Update an existing brand
     public function update(Request $request, $id)
     {
         
         try{
             $brand = Brand::findOrFail($id);
             $data=$request->validate([
                 'name'=>['required','string',new NotNumbersOnly(),"unique:brands,name,$brand->id"],
                 'image'=>['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
                 'status'=>['integer','in:0,1']
             ]);
           
            $data['image']=$this->updateImage($brand->image);
            $brand->update($data);
          
            return $this->success(200,data:$brand,message:__("Data updated successfuly"));
    
        }catch(ModelNotFoundException $e)
        {return $this->success(200,[],__("No data found"));}
    
     }
 
     // Delete a brand
     public function destroy($id)
     {
        try{

            $brand = Brand::findOrFail($id);
            $brand->delete();
            return $this->success(200,[],__("Data deleted successfuly"));
        }catch(ModelNotFoundException $e)
            {return $this->success(200,[],__("No data found"));}

     }
     public  function updateImage($imageName)
     {
         if (request()->hasFile('image')) {
             deleteImage($imageName, "Brands");
             return uploadImage(request()->file('image'), "Brands");
         } else {
             return $imageName;
         }
     }
     public function getAllBrands()
    {
        $brands = Brand::whereStatus(true)->get();
         if ($brands->isEmpty())
         {
            return $this->success(200,[],__("No data found"));
         }
         $result = $brands->map(function($brand){
            return [
                'id'=>$brand->id,
                'name'=>$brand->name,
                'image'=>getImagePathFromDirectory($brand->image,'Brands')
            ];
         }) ;
         return $this->success(200,data:$result);
    }
}
