<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\CartDetail;
use App\ProductImage;
use App\Attributes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
	public function index() //listado
	{
		$products = Product::paginate(1000); //ESTA PARTE HAY QUE ARREGLARLA
		return view('admin.products.index')->with(compact('products'));
	}

	public function create() //formulario de registro 
	{
		$categories = Category::orderBy('name')->get();
		$attributes = Attributes::orderBy('value')->get();
		return view('admin.products.create')->with(compact('categories', 'attributes'));
	}

	public function store(Request $request) //registrar nuevos productos
	{
		//dd($request->all());

		//validacion
		$rules = [
			'name' => 'required|min:3',
			'description' => 'required|max:200',
			'price' => 'required|numeric|min:0',
		];
		$this->validate($request, $rules);


		$product = new Product();
		$product->name = $request->input('name');
		$product->description = $request->input('description');
		$product->price = $request->input('price');
		$product->long_description = $request->input('long_description');
		$product->category_id = $request->category_id;
		$product->attribute_id = $request->attribute_id;
		$product->save();

		$quantity = $request->input('quantyti');
		 DB::insert('insert into products_attributes (product_id, attribute_id, qty) values 
		 			(?,?,?)', [$product->id,$request->attribute_id, $quantity]);

		return redirect('admin/products');
	}

	public function edit($id)
	{
		$categories = Category::orderBy('name')->get();
		$product = Product::find($id);
		$attributes = Attributes::orderBy('description')->get();
		return view('admin.products.edit')->with(compact('product', 'categories', 'attributes'));
	}

	public function update(Request $request, $id)
	{
		//validacion
		$rules = [
   		'name' => 'required|min:3',
   		'description' => 'required|max:200',
   		'price' => 'required|numeric|min:0',
   	];
   	$this->validate($request, $rules);

		$product = Product::find($id);
		$product->name = $request->input('name');
		$product->quantity = $request->input('quantity');
		$product->price = $request->input('price');
		$product->description = $request->input('description');
		$product->long_description = $request->input('long_description');
		$product->category_id = $request->category_id;
		$product->attribute_id = $request->attribute_id;
		$product->save();

		return redirect('admin/products');
	}

	public function destroy($id)
	{
		//NOTA: SI SE DESEA NO  ELIMINAR LOS PRODUCTOS QUE TENGAN VENTAS O ESTEN EN EL CARRITO, HAY QUE CAMBIAR ESTA LOGICA Y VALIDAR ANTES DEL DELETE

		//eliminamos relacion
		CartDetail::where('product_id', $id)->delete();
		ProductImage::where('product_id', $id)->delete();

		//eliminamos producto
		$product = Product::find($id);
		$product->delete();

		Session::flash('msg', 'Se eliminó el producto y las imágenes asociadas');
		return back(); //como el user ya esta ubicado en el fom products, solo hacemos un back
	}
}
