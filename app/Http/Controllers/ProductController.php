<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tag;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->toArray();
        return array_reverse($products);      
    }
    public function store(Request $request)
    {
        $Rtags = $request->input('tags');
        $path = $request->file('picture')->store('public/images');
        $product = new Product([
            'name' => $request->input('name'),
            'detail' => $request->input('detail'),
            'categoryid' => $request->input('categoryid'),
            'barcode' => $request->input('barcode'),
            'picture' => $path,
        ]);
        $product->save();
        $product = Product::select()->orderByDesc('id')->first();
        $tags = new Tag();
        foreach($Rtags as $tag){
            $tags->tag_name = $tag['text'];
            $tags->product_id = $product->id;
            $tags->save();
        }
        return response()->json('Product created!');
    }
    public function show($id)
    {
        $product = Product::find($id);
        $tags = Tag::where('product_id', $id)->get();
        return response()->json($product);
    }
    public function update($id, Request $request)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json('Product updated!');
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        $tags = Tag::where('product_id', $id)->get();
        if(isset($tags)){
            foreach($tags as $tag){
                $tag->delete();
            }
        }
        $product->delete();
        return response()->json('Product deleted!');
    }
    public function verifyBarcode(Request $request){

        $product = Product::where('barcode', $request->barcode)->first();
        if(isset($product)){
            return response()->json(['verify' => false, 'text' => 'This Barcode already exists']);
        }else{
            return response()->json(['verify' => true, 'text' => 'This Barcode not exists']);
        }
    }
}