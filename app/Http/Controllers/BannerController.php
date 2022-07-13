<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = Banner::orderBy('id', 'DESC')->get();
        return response()->json(["data" => $banner], Response::HTTP_OK);
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
            'description' => 'required|min:8',
            'photo' => 'required|file|mimes:png,jpeg,jpg',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:banner,promo'
        ]);

        $imageName = $request->file('image');
        $imagePath = $imageName->storeAs('public/images/banner', rand(1, 99999) . $imageName->getClientOriginalName());

        Banner::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'photo' => $imagePath,
            'status' => $request->status,
            'condition' => $request->condition,
        ]);

        return response()->json(["message" => 'banner created success'], Response::HTTP_CREATED);
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
            'description' => 'required|min:8',
            'photo' => 'required|file|mimes:png,jpeg,jpg',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:banner,promo'
        ]);

        $imageName = $request->file('image');
        $imagePath = $imageName->storeAs('public/images/banner', rand(1, 99999) . $imageName->getClientOriginalName());

        Banner::where('id', $id)->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'photo' => $imagePath,
            'status' => $request->status,
            'condition' => $request->condition
        ]);

        return response()->json(
            ["message" => 'Banner updated successfully'],
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
        $banner = Banner::find($id);
        if ($banner) {
            $banner->delete();

            return response()->json(
                [
                    'message' => 'Banner deleted successfully'
                ],
                Response::HTTP_CREATED
            );
        }
        return response()->json(
            [
                'message' => 'Inavlid banner ID'
            ],
            Response::HTTP_NOT_FOUND
        );
    }
}
