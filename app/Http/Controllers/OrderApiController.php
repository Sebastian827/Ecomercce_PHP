<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\ProductApiController;
use App\Models\OrderProduct;

class OrderApiController extends Controller
{
    public function create(Request $request){
        $order = new Order();

        $order->email=$request->email;
        if(empty($order->email)){
            return response()->json(['message' => 'email is requerid'], 404);
        }
        $order->save();
        $productos= $request->products;

        $num=1;
        $productos= $request->products;
        foreach( $productos as $product){
            $id = $product['product_id'];
            $productss = Product::with(['Category', 'Brand', 'Seller'])
            ->where('id', $id)    
            ->first();
            if(empty($productss)){
                return response()->json(['message' => 'Not Found product number '. $num], 404);
            }
            
            if($productss->inventory<$product['quantity']){
                return response()->json(['message' => 'there is not enough stock of the product '. $num], 404);
            }
            $productss->inventory=$productss->inventory-$product['quantity'];
            $productss->save();
            
            ++$num;
        }
        $order->products()->attach($request->products);



        
    }

    public function getByEmail($email){
        $productss = Order::with(['products'])
        ->where('email', $email)->get();
        

        return $productss;

    }


}
