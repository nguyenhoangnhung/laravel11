<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Attribute;
use App\Value;
use App\Product;
use App\Category;
use App\SubCategory;
use Yajra\Datatables\Datatables;


class ProductController extends Controller
{
    public function index() {
    	$atts = Attribute::select('id', 'column')->get();
        $categories = Category::select('id','name')->get();
        $subcategories = SubCategory::select('id','name')->get();
        return view('products.list', [
    		'atts' =>$atts,
            'categories' => $categories,
            'subcategories' => $subcategories
    	]);

    }

    public function anyData(){
    	$atts = Attribute::select('id', 'column')->get();

    	$products = Product::orderBy('id', 'asc')->get();

    	foreach ($products as $key => $product) {
    		foreach ($atts as $key => $att) {
    			$cot = $att->column;

    			$flag = Value::where('attribute_id', $att->id)->where('product_id', $product->id)->first();

    			if (!empty($flag)) {
    				$product->$cot = $flag->value;
    			}
    			else {
    				$product->$cot = 'unknown';
    			}
    			
    		}
    	}

    	return datatables()->of($products)
    		// ->editColumn('price', function ($product) {
    		// 	return number_format(integer($product->price)) . ' VND';
    		// })
    		->addColumn('action', function($product) {
				return '<button class="btn btn-xs btn-info DetailAdd" title="Add Details" data-id="'.$product->id.'" data-toggle="modal" data-target="#AddDetail"><i class="fa fa-edit"></i></button> <button class="btn btn-xs btn-warning ShowDetail" data-id="'.$product->id.'"><i class="fa fa-folder-open" title="Show"></i></button> <button class="btn btn-xs btn-primary uploadImg" title="Upload Images" data-id="'.$product->id.'" data-toggle="modal" data-target="#uploadImage"><i class="fa fa-file-image-o"></i></button> <button class="btn btn-xs btn-danger" title="Delete" data-id="'. $product->id.'"><i class="fa fa-trash"></i></button>';
			})
            
			->rawColumns(['email', 'action'])
    		->toJson();
    }

    public function add(Request $request){
    	$data = $request->all();

    	unset($data['_token']);
    	$product = Product::create();
        
        // dd($abc);
    	// $atts = Attribute::select('id', 'column')->get();
    	foreach ($data as $key => $value) {
            $att = Attribute::where('column', $key)->first();
            if(isset($att)){
                Value::create([
                    'product_id' => $product->id,
                    // 'attribute_id' => Attribute::where('column', $key)->first()->id,
                    'attribute_id' =>$att->id, 
                    'value' => $value

                ]);
            }
    		
    	}
        // dd($data);
    }

    public function destroy(Request $request,$id) {
		Product::find($id)->delete();
        Value::where('product_id', $id )->delete();
		return response()->json(['messsage' => 'Xoa thanh cong']);
	}

    public function upload(Request $request){
        // dd($request->all());
        $path=$request->file->storeAs('images','image_'.time().'.png');
        $proImg = \App\ProductImage::create([
            'product_id'=>$request->product_id,
            'thumbnail'=>$path,
        ]);
        return response()->json([
            'data' => $proImg
        ]);
    }

    // public function store(Request $request, $id){
    //     // $data=$request->all();
    //     // $data['code']='SP'.time();
    //     // unset($data['_token']);
    //     // $product= Product::find($id);
    //     // $atts= Attribute::select('id','column')->get();
    //     // foreach ($data as $key => $value) {
    //     //     $att = Attribute::where('column',$key)->first();
    //     //     if(isset($att)){
    //     //         Value::create([
    //     //             'product_id'=> $id,
    //     //             // 'code' => $data['code'],
    //     //             'size' => $data['size'],
    //     //             'color' => $data['color'],
    //     //         ]);
    //     //     }
    //     }
    //     return response()->json([
    //         'error'=>false,
    //         'product_id'=>$product->id,
    //     ]);
    // }
    

    public function show($id){
        $product=Product::where('id',$id)->first();   
        $values=Values::where('products_id', $id)
            ->join('name','name.id', '=','name_id')
            ->join('price', 'price.id','price_id')
            ->join('description', 'description.id','description_id')
            ->join('material', 'material.id','material_id')
            ->join('size', 'size.id','size_id')
            ->join('color', 'color.id','color_id')
            ->join('category', 'category.id','category_id')
            ->join('subcategory', 'subcategory.id','subcategory_id')
            ->select('name.name as name','price.price as price','description.description as description','material.material as material','size.size as size','color.color as color','category.category as category','subcategory.subcategory as subcategory')
            ->first();

        $product->name = $values->name;
        $product->price = $values->price;
        $product->description = $values->description;
        $product->material = $values->material;
        $product->size = $values->size;
        $product->color = $values->color;
        $product->category = $values->category;
        $product->subcategory = $values->subcategory;
        dd($product);
        $images =ProductImage::where('product_id',$id)->paginate();
        foreach ($images as $image) {
            $image->link = asset(\Storage::url($image->link));
        }
// dd($image);
        return response()->json([
            'product'=>$product,
            'images'=>$images,
           
        ]);
        
}

}
