<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    protected $product;

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        dd('hi');
        if ($request->ajax())
        {
            return $this->product->getProducts($request);
        }
        return view('backend.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $filename = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            // Upload the original image to the "product" folder
            $originalPath = 'products/' . $filename;
            Storage::disk('public')->put($originalPath, file_get_contents($image));

            // Create a copy of the original image and resize it to 400x600 pixels
            $resizedImage = Image::make(storage_path('app/public/' . $originalPath))
                ->resize(445, 450);

            // Save the resized image to the "best_seller" folder
            $bestSellerPath = 'products/best_seller/' . $filename;
            Storage::disk('public')->put($bestSellerPath, $resizedImage->encode());

            // Create a copy of the original image and resize it to 317x317 pixels
            $resizedImage = Image::make(storage_path('app/public/' . $originalPath))
                ->resize(317, 317);

            // Save the resized image to the "best_seller" folder
            $bestSellerPath = 'products/trendings/' . $filename;
            Storage::disk('public')->put($bestSellerPath, $resizedImage->encode());

            // You can also save the original image path to your database or perform any additional tasks here
        }
        $productStore = $this->product->create([
            "price" => $request->price,
            "stock_quantity" => $request->stock_quantity,
            "category_id" => $request->category,
            "weight" => $request->weight,
            "image" => $filename,
        ]);
        foreach ($request->lang as $key => $value) {
            if ($request->name[$key] != null) {
                ProductTranslation::create([
                    'product_id' => $productStore->id,
                    'language_code' => $value,
                    'name' => $request->name[$key],
                    'description' => $request->description[$key],
                ]);
            }
        }
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $product   = $this->product->find($id);
        $related_tables = ['expenses'];
        $count = 0;
        try {

            if(count($request->ids) > 0){

                $categories = $this->category->whereIn('id', $request->ids)->get();
                DB::beginTransaction();

                foreach ($categories as $key => $value) {

                    if(checkForDelete($related_tables, 'category_id', $value->id) == false){

                        // $this->crd->where('currency_id', $value->id)->delete();
                        deleteRecord('categories', 'id', $value->id);
                    }else {
                        $count += 1;
                    }

                }
                DB::commit();
                if($count > 0){
                    return ['result' => 0, 'message' => 'First Delete Related Data'];
                } else {

                    return ['result' => 1, 'message' => __('message.success')];
                }
            } else {
                // DB::beginTransaction();
                $category = $this->category->find($id);

                if(checkForDelete($related_tables, 'category_id', $id) == false){

                    // $this->crd->where('currency_id', $id)->delete();
                    deleteRecord('categories', 'id', $id);
                    return ['result' => 1, 'message' => __('message.success')];
                }
                // DB::commit();
            }

            return ['result' => 0, 'message' => 'First Delete Related Data'];
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => __('message.error')], 422);
        }
    }
}
