<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attribute;
use App\Value;
use App\Product;
use App\Category;
use App\SubCategory;
use App\ProductImage;
use App\SizeColor;
use App\Color;
use App\Size;
use DB;

class StoreController extends Controller
{
    

	public function index(){
		$products=Product::all();
		$i=[];
		$a=[];
		$atts = Attribute::select('id','column')->get();
		foreach ($products as $keya => $product) {
			$imgs=ProductImage::where('product_id',$product->id)->first();
			
		if (isset($imgs)) {
			$product->image=$imgs->thumbnail;
		}
			
			
			foreach ($atts as $att) {
				$cot = $att->column;
				$value = Value::where('product_id', $product->id)
				->where('attribute_id', $att->id)
				->first();
				if(isset($value)){
					$product->$cot = $value->value;
		    		// dd($product);
				}
			}
		
		}
      
		return view('store.index',[
			'products'=>$products,
			
			]);

	}

	public function show($id){
		$array = array();
        $aaa=[];
        $sp=[];
        $se=[];
        $app=[];
     
        $image=ProductImage::where('product_id',$id)->get();
  
        $aaa['image']=$image;
        // dd($aaa);
        $atts=Attribute::select('id','column')->get();
       
        
           foreach ($atts as $key1 => $att) {
               $cot=$att->column;
               $a=Value::where('product_id',$id)->where('attribute_id',$att->id)->first();
               if (isset($a)) {
             $app[$cot]=$a->value;
               }
               // unset($value->value);
           }
        $sizescolors=SizeColor::where('product_id',$id)->get();
        foreach ($sizescolors as $key2 => $sizecolor) {
        	$size=Size::where('id',$sizecolor->size_id)->first()->sizename;
        	$color=Color::where('id',$sizecolor->color_id)->first()->color;
        	$sp[$key2]['size']=$size;
        	$sp[$key2]['color']=$color;
        	// dd($size);
        }
        // dd($sp);
        return view('store.detail', [
        	'aaa'=>$aaa,
        	'app'=>$app,
        	'sp'=>$sp
        ]);
	}
}
