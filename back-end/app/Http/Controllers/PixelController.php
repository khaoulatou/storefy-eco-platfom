<?php

namespace App\Http\Controllers;

use App\Models\Pixel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PixelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function index()
    {
        //
//        print_r(auth('sanctum')->user()->id);
        return response()->json(
            [
                'message' => 'success',
                'data' => Pixel::where('user_id', auth('sanctum')->user()->id)->get()
            ],
            201);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        //
        $req = Validator::make($request->only(['name', 'pixel']), [
            'name' => ['required'],
            'pixel' => ['required']
        ]);
        if ($req->fails()) {
            return response()->json(['message' => 'error', 'data' => $req->errors()], 400);
        }
        $pixel = Pixel::create(
            [
                'name' => $request->input('name'),
                'pixel' => $request->input('pixel'),
                'user_id' => auth('sanctum')->user()->id,
            ]
        );
        if ($pixel) {
            return response()->json(['data' => $pixel, 'message' => 'success'], 201);
        }
        return response()->json(['message' => 'error', 'status' => 'We can\'t save your pixel'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param Pixel $pixel
     * @return JsonResponse
     */
    public function show(Pixel $pixel): JsonResponse
    {
        //
        //
        return response()->json(['data' => $pixel, 'message' => "success"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Pixel $pixel
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
//        return $request->all();
        //
        $req = Validator::make($request->only(['name', 'pixel']), [
            'name' => ['required'],
            'pixel' => ['required']
        ]);
        if ($req->fails()) {
            return response()->json(['error', $req->errors()], 400);
        }
        $pixel = Pixel::where('id', $id)->update(['name' => $request->name, 'pixel' => $request->pixel]);
        if ($pixel) {
            return response()->json(['message' => 'success'], 201);
        }
        return response()->json(['message' => 'error'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Pixel $pixel
     * @return JsonResponse
     */
    public function destroy(Pixel $pixel)
    {
        //
        if ($pixel->delete()) {
            return response()->json(['message' => "success"]);
        }
    }
}
