<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pagination = 9;
        $categories = Category::all();

        if(request()->category){
            $products = Product::with('categories')->whereHas('categories', function($query){
                $query->where('slug', request()->category);
            });

//            $categoryName = Category::where('slug', request()->category)->first()->name ?? '';
            $categoryName = optional(Category::where('slug', request()->category)->first())->name;
        }
        else{
            $products = Product::where('featured', true)->inRandomOrder() ?? false;
            $categoryName = 'Featured';
        }

        if(request()->sort === 'low_high'){
            $products = $products->orderBy('price')->paginate($pagination);
        }elseif(request()->sort === 'high_low'){
            $products = $products->orderBy('price', 'desc')->paginate($pagination);
        }else{
            if($products){
                $products = $products->paginate($pagination);
            }
        }

        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug',$slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug','!=',$slug)->mightAlsoLike()->get();

        return view('product')->with([
                                        'product' => $product,
                                        'mightAlsoLike' => $mightAlsoLike
                                    ]);
    }

}
