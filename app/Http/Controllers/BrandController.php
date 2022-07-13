<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand = Brand::all();
        return response()->json(['brand', $brand], Response::HTTP_OK);
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
            'photo' => 'required|file|mimes:png,jpeg,jpg',
            'status' => 'required|in:active,inactive',
        ]);


        $imageName = $request->file('photo');
        $imagePath = $imageName->storeAs('public/images/brand', rand(1, 99999) . $imageName->getClientOriginalName());


        Brand::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'photo' => $imagePath,
            'status' => $request->status,
        ]);

        return response()->json(["message" => 'Brand created successfully'], Response::HTTP_CREATED);
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
            'photo' => 'required|file|mimes:png,jpeg,jpg',
            'status' => 'required|in:active,inactive',
        ]);


        $imageName = $request->file('photo');
        $imagePath = $imageName->storeAs('public/images/brand', rand(1, 99999) . $imageName->getClientOriginalName());

        Brand::where('id', $id)->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'photo' => $imagePath,
            'status' => $request->status,
        ]);

        return response()->json(
            ["message" => 'Brand updated successfully'],
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
        $brand = Brand::find($id);
        if ($brand) {
            $brand->delete();

            return response()->json(
                [
                    'message' => 'Brand deleted successfully'
                ],
                Response::HTTP_CREATED
            );
        }
        return response()->json(
            [
                'message' => 'Inavlid brand ID'
            ],
            Response::HTTP_NOT_FOUND
        );
    }
}
