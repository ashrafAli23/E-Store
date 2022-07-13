<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return response()->json(['category', $category], Response::HTTP_OK);
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
            'summary' => 'required|min:8',
            'photo' => 'required|file|mimes:png,jpeg,jpg',
            'is_parent' => 'boolean',
            'parent_id' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);


        $imageName = $request->file('photo');
        $imagePath = $imageName->storeAs('public/images/category', rand(1, 99999) . $imageName->getClientOriginalName());


        Category::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'summary' => $request->summary,
            'photo' => $imagePath,
            'status' => $request->status,
            'is_parent' => $request->is_parent,
            'parent_id' => $request->parent_id
        ]);

        return response()->json(["message" => 'Category created successfully'], Response::HTTP_CREATED);
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
            'summary' => 'required|min:8',
            'photo' => 'required|file|mimes:png,jpeg,jpg',
            'is_parent' => 'boolean',
            'parent_id' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);


        $imageName = $request->file('photo');
        $imagePath = $imageName->storeAs('public/images/category', rand(1, 99999) . $imageName->getClientOriginalName());

        Category::where('id', $id)->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'summary' => $request->summary,
            'photo' => $imagePath,
            'status' => $request->status,
            'is_parent' => $request->is_parent,
            'parent_id' => $request->parent_id
        ]);

        return response()->json(
            ["message" => 'Category updated successfully'],
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
        $category = Category::find($id);
        if ($category) {
            $category->delete();

            return response()->json(
                [
                    'message' => 'Category deleted successfully'
                ],
                Response::HTTP_CREATED
            );
        }
        return response()->json(
            [
                'message' => 'Inavlid category ID'
            ],
            Response::HTTP_NOT_FOUND
        );
    }
}
