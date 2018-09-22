<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Color;
use App\SizeColor;
use App\Size;
use App\Quantity;

class SizeColorController extends Controller
{
	public function store(Request $request){
		// dd($request->all());
	$re=Color::where('color',$request->color)->first();
	// dd($re);
	if(empty($re)){
		
		$color=Color::create(['color'=>$request->color]);
		
		$sizecolors=SizeColor::create(['product_id'=>$request->id,'size_id'=>$request->size,'color_id'=>$color->id]);
		$quantities = Quantity::create(['size_id'=>$request->size, 'color_id'=>$color->id,'value'=>$request->quantity]);

	}else{
	$color_id=Color::where('color',$request->color)->first()->id;

		$sizecolors=SizeColor::create(['product_id'=>$request->id,'size_id'=>$request->size,'color_id'=>$color_id]);	
		// dd($re);
		$quantities = Quantity::create(['size_id'=>$request->size, 'color_id'=>$re->id,'value'=>$request->quantity]);
	}
// dd($sizecolors);
	}
}
