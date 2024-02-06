<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'price',
        'discount',
        'stock_quantity',
        'category_id',
        'sub_category_id',
        'brand_id',
        'featured',
        'is_active',
        'image',
        'gallery_image',
        'slug',
        'weight',
        'dimensions',
        'tags',
        'language',
        'sizes',
        'colors',
        'unit'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getProducts($request)
    {
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        // return $per_page;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $query = DB::table('products')
            ->leftJoin('product_translations','product_translations.product_id','products.id')
            ->leftJoin('categories','categories.id','category_id')
            ->selectRaw('product_translations.name,products.price,products.stock_quantity,categories.name as category')
            ->groupBy('product_translations.product_id');

        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }

        if ($filter != '') {
            $query = $query->where('products.name', 'like', '%' . $filter . '%');
        }

        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        return $query->paginate($per_page);
    }

    public function getProductsList($keywords=null){
        $currentLanguage = app()->getLocale();
        $products = Product::join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->select(
                'products.*',
                'product_translations.name as name',
                'product_translations.description as description',
                \DB::raw('(SELECT name FROM categories WHERE categories.id = products.category_id) as category_name')
            )
            ->where('product_translations.language_code', $currentLanguage)
            ->with('category')
            ->get();
        return $products;
    }

}
