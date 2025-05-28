<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\PanelingSpecificationController;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Order;
use App\Models\Paneling;
use App\Models\PanelingOrder;
use App\Models\PanelingSpecification;
use App\Rules\NotNumbersOnly;
use App\Rules\PhoneNumbers;
use App\Trait\JsonResponsable;
use Exception;
use Faker\Provider\bg_BG\PhoneNumber;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    use JsonResponsable;

    public function getProductInfo(Paneling $product_id)
    {
        if (!$product_id->category) {
            return $this->failure(404, __('This Product Is Not Assigned To Valid Category Or Its Category Deleted'));
        }
        $result = collect([$product_id])->map(function ($product) {
            return [
                'id' => $product->id,
                'category' => $product->category->id,
                'category_data' => [
                    'name' => $product->category->name,
                    'image' => $product->category->image
                ],
                'image' => $product->image,
                'description' => $product->description,
                'car_specifications' => $product->specifications->map(function ($spec) {
                    return [
                        'id' => $spec->id,
                        'brand' => $spec->brand->id,
                        'brand_data'=>[
                            'name' => $spec->brand->name,
                            'image' => $spec->brand->image
                        ],
                        'model' => $spec->model->id,
                        'model_data'=>[
                            'name' => $spec->model->name,
                            'image' => $spec->model->image
                        ],
                        'type' => $spec->car_chairs,
                        'price' => $spec->price,
                        'is_connect' => $spec->is_connect,

                    ];
                }),
            ];
        });

        return $this->success(200, $result);
    }
    public function getAllProduct($catId)
    {
        $products = Paneling::where('category_id', $catId)
            ->with('specifications')
            ->get();
        $brands = Brand::where('status', 1)->get();

        if ($products->isEmpty()) {
            return $this->success(200, [], __("No data found"));
        }

        $result = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'image' => $product->image,
                'description' => $product->description,
                'car_type' => $product->specifications->map(function ($spec) {
                    return [
                        'id' => $spec->id,
                        'type' => $spec->car_chairs,
                        'price' => $spec->price,
                        'is_connect' => $spec->is_connect,

                    ];
                })
            ];
        });
        $result['brands'] = $brands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name
            ];
        });

        return $this->success(200, $result);
    }
    public function getModelOrder($brandId)
    {
        $models = CarModel::where('brand_id', $brandId)
            ->where('status', 1)
            ->get();
        if ($models->isEmpty()) {
            return $this->success(200, [], __("No data found"));
        }
        return $this->success(200, $models->map(function ($model) {
            return [
                'id' => $model->id,
                'name' => $model->name,
                'start_year' => $model->startYear,
                'end_year' => $model->endYear,
                'image_start_year' => $model->image_start_year,
                'image_end_year' => $model->image_end_year
            ];
        }));
    }

    public function makeOrder(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'paneling_ids' => ['required', 'array'],
            'paneling_ids.*.id' => [
                'required_with:paneling_ids',
                Rule::exists('panelings', 'id')->whereNull('deleted_at'),
            ],
            'paneling_ids.*.quantity' => ['required_with:paneling_ids', 'min:1', 'integer'],
            'address' => ['required', 'string', new NotNumbersOnly()],
            'paneling_ids.*.car_type' => ['required', 'in:3,5,7'],
            'paneling_ids.*.model_ids' => ['array'],
            'paneling_ids.*.model_ids.*.id' => [
                'required',
                Rule::exists('models', 'id')->whereNull('deleted_at'),
            ],
            'paneling_ids.*.brand_ids' => ['array'],
            'paneling_ids.*.brand_ids.*.id' => [
                'required',
                Rule::exists('brands', 'id')->whereNull('deleted_at'),
            ],
            'paneling_ids.*.manufacturing_year' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'mobile' => ['required', new PhoneNumbers()],
            'paneling_ids.*.is_connect' => ['required', 'in:0,1'],
            'paneling_ids.*.model_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'note' => ['nullable', 'string'],

        ]);


        try {
            DB::beginTransaction();

            // Calculate total price
            $totalPrice = 0;
            foreach ($validatedData['paneling_ids'] as $panelingData) {
                $price = PanelingSpecification::where('paneling_id', $panelingData['id'])
                    ->where('car_chairs', $panelingData['car_type'])
                    ->value('price');
                $totalPrice += ($price * $panelingData['quantity']);
            }

            // Create the order
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'status' => 1,
                'note' => $validatedData['note'] ?? null,
                'total' => $totalPrice,
                'address' => $validatedData['address'],
            ]);

            // Process each paneling item
            foreach ($validatedData['paneling_ids'] as $panelingData) {
                $uploadedImage = isset($panelingData['model_image'])
                    ? uploadImage($panelingData['model_image'], 'Orders')
                    : null;

                foreach ($panelingData['model_ids'] as $model) {
                    foreach ($panelingData['brand_ids'] as $brand) {
                        $panelingSpec = PanelingSpecification::where('paneling_id', $panelingData['id'])
                            ->where('car_chairs', $panelingData['car_type'])
                            ->where('model_id', $model['id'])
                            ->where('brand_id', $brand['id'])
                            ->with(['model:id,name', 'brand:id,name']) // Eager load model and brand
                            ->first();

                        if (!$panelingSpec) {
                            throw new Exception("Specification not found for paneling ID: {$panelingData['id']} with Model ID: {$model['id']} and Brand ID: {$brand['id']}");
                        }

                        PanelingOrder::create([
                            'order_id' => $order->id,
                            'paneling_id' => $panelingData['id'],
                            'quantity' => $panelingData['quantity'],
                            'cost' => $panelingSpec->price,
                            'manufacturing_year' => $panelingData['manufacturing_year'],
                            'is_connect' => $panelingData['is_connect'],
                            'model' => $panelingSpec->model->name ?? null,
                            'brand' => $panelingSpec->brand->name ?? null,
                            'model_image' => $uploadedImage,
                        ]);
                    }
                }
            }

            DB::commit();

            return $this->success(200, __('Order Successfully Completed'));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure(500, __($e->getMessage()));
        }
    }


    public function getAllOrder()
    {
        $orders = Order::all();
        if ($orders->isEmpty()) {
            return $this->success(200, [], __("No data found"));
        }
        return $this->success(200, $orders);
    }
    public function showOrderDashboard($id)
    {
        try {
            $order = Order::findOrFail($id);
            return $this->success(200, $order);
        } catch (ModelNotFoundException $e) {
            return $this->failure(404, __("No data found"));
        }
    }
    public function deleteOrderDashboard($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return $this->success(200, __("Data deleted successfuly"));
        } catch (ModelNotFoundException $e) {
            return $this->failure(404, __("No data found"));
        }
    }
}
