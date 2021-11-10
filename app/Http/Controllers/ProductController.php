<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
class ProductController extends Controller{

    public function index(Request $request){
        $data = [];
        if($this->checkSession($request)){
            $token = $request->session()->get('token');
            $data['token'] = $token;
        }
        $products = [];
        if($request->session()->exists('products')){
            $products = $request->session()->get('products');
        }
        
        $data['products'] = $products;
        if($request->session()->exists('message') && $resources = $request->session()->exists('code') ){
            $data['message'] = $resources = $request->session()->get('message');
            $data['code'] = $resources = $request->session()->get('code');
        }
        return view('product.index', $data);
    }

    public function create(Request $request){
        if(!$this->checkSession($request)){
            return redirect('login');
        }
        $token = $request->session()->get('token');
        $data['token'] = $token;
        
        if($request->session()->exists('message') && $resources = $request->session()->exists('code') ){
            $data['message'] = $resources = $request->session()->get('message');
            $data['code'] = $resources = $request->session()->get('code');
        }
        return view('product.create', $data);
    }

    public function store(Request $request){
        if(!$this->checkSession($request)){
            return redirect('login');
        }
        $data = [];
        $id = 1;
        if($request->session()->exists('products')){
            $products = $request->session()->get('products');
            if(!empty($products)){
                $lastp = end($products);
                $id = $lastp['id'] +1;  
            }
        }
        $name = $request->input('name');
        $price = $request->input('price');
        $products = [];
        if($request->session()->exists('products')){
            $products = $request->session()->get('products');
        }
        if(empty($id) || empty($name) || empty($price)){
            //Volvemos, codigo de error y mensaje de error.
            $data['code'] = 403;
            $data['message'] = "Revisa que los campos esten rellenos";
            return back()->withInput()->with($data);
            
        }else if($price <= 0){
            $data['code'] = 406;
            $data['message'] = "El precio no puede ser negativo";
            return back()->withInput()->with($data);
        } else{
            
            $data['code'] = 200;
            $data['message'] = "Producto añadido correctamente";
            $product = ["id"=>$id, "name"=>$name, "price"=>$price];
            $products[$id] = $product;
            
            $request->session()->put('products', $products);

            return redirect('products')->with($data);
        }
    }

    public function show(Request $request, $id){
        $data = [];    
        if($request->session()->exists('products')){
            $products = $request->session()->get('products');
            if(isset($products[$id])){
                $product = $products[$id];
                $data['product'] = $product;
                if($request->session()->exists('message') && $resources = $request->session()->exists('code') ){
                    $data['message'] = $resources = $request->session()->get('message');
                    $data['code'] = $resources = $request->session()->get('code');
                }
                return view('product.show', $data);
            } else{

                return abort("404");
            }
        } else{
            echo"asdf";
            $data['code'] = 404;
            $data['message'] ="Ha habido un error al buscar el producto que buscas.";
            return abort(404);
        }
    }     
    

    public function edit(Request $request, $id){
        $data = [];
        if(isset($request->session()->get('products')[$id])){
            $data['product'] = $request->session()->get('products')[$id];
            
        if($request->session()->exists('message') && $resources = $request->session()->exists('code') ){
            $data['message'] = $resources = $request->session()->get('message');
            $data['code'] = $resources = $request->session()->get('code');
        }
            
            return view('product.edit', $data);
        } else{
            $data['code'] = 404;
            $data['message'] ="Ha habido un error al buscar el producto que buscas.";
            
            return redirect('index', $data);
        }

    }

    public function update(Request $request, $id){
        $data = [];
        if($request->session()->exists('products')){
            $products = $request->session()->get('products');
            $product = $products[$id];
            $newName = $request->input('name');
            $newPrice = $request->input('price');
            if(empty($newPrice) || empty($newPrice)){
                $data['code'] = 405;
                $data['message'] = "Los campos no pueden estar en blanco";
                return back()->withInput()->with($data);    
            }else if($newPrice <= 0){
                $data['code'] = 406;
                $data['message'] = "El precio no puede ser negativo";
                return back()->withInput()->with($data);
            } else{
                $product['name'] = $newName;
                $product['price'] = $newPrice;
                $products[$id] = $product;
                $request->session()->put('products', $products);
                $data['code'] = 200;
                $data['message'] = "Producto actualizado exitosamente";
                return redirect('products')->with($data);
            }
            
        } else{
            $data['code'] = 402;
            $data['message'] = "Ha ocurrido un error al actualizar la información";
            return back()->withInput()->with($data);
        }
    }

    public function destroy(Request $request, $id){
        $data = [];
        if($request->session()->exists('products')){
            $products = $request->session()->get('products');
            if(isset($products[$id])){
                unset($products[$id]);
                $data['code'] = 200;
                $data['message'] = "Borrado con exito";
                $request->session()->put('products', $products);

            } else{
                $data['code'] = 401;
                $data['message'] = "Ha ocurrido un error al borrar el producto.";
            }
        }
        return redirect('products')->with($data);
    }
    
    public function checkSession(Request $request){
        if($request->session()->exists('token')){
            return true;
        }
        return false;
    }
}
