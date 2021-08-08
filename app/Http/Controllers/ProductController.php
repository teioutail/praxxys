<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Images;
use DB;

use Image; // image intervention

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!is_null($request->keyword) && is_null($request->category)) {
            
            // search keyword on both name and description field
            $product = DB::table('products')
            ->where('name', 'like', '%' . $request->keyword . '%')
            ->orWhere('description', 'like', '%' . $request->keyword . '%')->paginate(10);

        } else if(is_null($request->keyword) && !is_null($request->category)) {
             // search keyword on both name and description field
             $product = DB::table('products')->where('category', 'like', '%' . $request->category . '%')->paginate(10);
        
        }else if(!is_null($request->keyword) && !is_null($request->category)) { 
            
            // search keyword on both name and description field
            // dd($request->all());
            $product = DB::table('products')
            ->where(function ($query) use($request) {
                $query->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%');
            })
            ->where('category', '=', $request->category)->paginate(10);

        } else {
            // default view
            $product = DB::table('products')->paginate(10);
        }
        
        // return result in json format
        return response()->json($product);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'name'=>'required|max:255|unique:products',
            'category'=>'required',
            'description'=>'required',
            'files' => 'required',
            'files.*' => 'required|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        // Store files
        if($request->hasFile('files')) {

            // save data without image
            $product = new Product();
            $product->name = $request->name;
            $product->category= $request->category;
            $product->description = $request->description;
            $product->date_time = $request->date_time;
            $product->save();

            $pictures = [];

            foreach($request->file('files') as $file){

                 // Get filename with the extension
                $filenameWithExt = $file->getClientOriginalName();
            
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $file->getClientOriginalExtension();
    
                // Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                // Upload Image
                $path = $file->storeAs('public/products', $fileNameToStore);

                $pictures[] = $fileNameToStore;
               
            }

            foreach($pictures as $pic) {
                $images = new Images();
                $images->images = $pic;
                $images->product_id = $product->id;
                $images->save();
            }

        } else {

           // save data without image
           $product = new Product();
           $product->name = $request->name;
           $product->category= $request->category;
           $product->description = $request->description;
           $product->date_time = $request->date_time;
           $product->save();
        }
        // return response()->json($fileNameToStore);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $product = Product::where('id', $id)->first();
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // $validator = \Validator::make($request->all(), [
        //     'name'=>'required|max:255|unique:products,'.$id,
        //     'category'=>'required',
        //     'description'=>'required',
        //     'files' => 'required',
        //     'files.*' => 'required|mimes:jpg,jpeg,png',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        // $date = strtotime($request->date_time);
        // echo date('d/M/Y h:i:s', $date);        
        // dd($request->all());
        // form fields
        $data = array();
        $data['name'] = $request->name;
        $data['category'] = $request->category;
        $data['description'] = $request->description;
        $data['date_time'] = $request->date_time;

        // update record
        $update = DB::table('products')->where('id', $id)->update($data);
        return response()->json(['test'=>'shit','prod_id'=>$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete selected record
        $delete = Product::where('id',$id)->delete();
    }

    // view all category
    public function viewCategory() {

        $category = Product::select('category')->distinct()->get()->toArray();
        return response()->json($category);

    }

    public function searchProducts() {
        return response('testing');
    }

}
