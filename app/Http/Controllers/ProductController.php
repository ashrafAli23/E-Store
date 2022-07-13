<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return response()->json(['product', $product], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5',
            'summary' => 'required|min:5',
            'photo' => 'required|file|mimes:png,jpeg,jpg',
            'description' => 'required|min:8',
            'stock' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
            'size' => 'nullable',
            'condition' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);


        $imageName = $request->file('photo');
        $imagePath = $imageName->storeAs('public/images/product', rand(1, 99999) . $imageName->getClientOriginalName());

        Product::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'summary' => $request->summary,
            'description' => $request->description,
            'photo' => $imagePath,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'stock' => $request->stock,
            'price' => $request->price,
            'discount' => $request->discount,
            'offer_price' => ($request->price - (($request->price + $request->discount) / 100)),
            'size' => $request->size,
            'status' => $request->status,
            'condition' => $request->condition
        ]);

        return response()->json(["message" => 'Product created successfully'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json(['product' => $product], Response::HTTP_OK);
        }

        return response()->json(['message' => "Invalid product id"], Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'title' => 'required|min:5',
            'summary' => 'required|min:5',
            'photo' => 'required|file|mimes:png,jpeg,jpg',
            'description' => 'required|min:8',
            'stock' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
            'size' => 'nullable',
            'condition' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);


        $imageName = $request->file('photo');
        $imagePath = $imageName->storeAs('public/images/product', rand(1, 99999) . $imageName->getClientOriginalName());

        Product::where('id', $id)->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'summary' => $request->summary,
            'description' => $request->description,
            'photo' => $imagePath,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'stock' => $request->stock,
            'price' => $request->price,
            'discount' => $request->discount,
            'offer_price' => ($request->price - (($request->price + $request->discount) / 100)),
            'size' => $request->size,
            'status' => $request->status,
            'condition' => $request->condition
        ]);

        return response()->json(
            ["message" => 'Product updated successfully'],
            Response::HTTP_CREATED
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();

            return response()->json(
                [
                    'message' => 'Product deleted successfully'
                ],
                Response::HTTP_CREATED
            );
        }
        return response()->json(
            [
                'message' => 'Inavlid product ID'
            ],
            Response::HTTP_NOT_FOUND
        );
    }
}
