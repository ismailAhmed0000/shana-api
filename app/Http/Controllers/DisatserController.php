<?php

namespace App\Http\Controllers;

use App\Models\DisasterPoint;
use Illuminate\Http\Request;

class DisatserController extends Controller
{
    public function index()
    {
        $disaster = DisasterPoint::get();
        return response()->json(['message' => 'All DisasterPoint requests retrieved', 'data' => $disaster]);
    }

    public function show($id)
    {
        $disaster = DisasterPoint::find($id);
        return response()->json(['message' => 'DisasterPoint request retrieved ', 'data' => $disaster]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:flood,storm,earthquake,fire',
            'description' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'disaster_level' => 'required:low,medium,high,very_high'
        ]);

        $disaster = DisasterPoint::create($data);

        return response()->json([
            'message' => 'DisasterPoint request created successfully',
            'data' => $disaster,
        ], 201);
    }

    public function update(Request $request, DisasterPoint $disaster)
    {
        $data = $request->validate([
            'type' => 'sometimes|in:flood,storm,earthquake,fire',
            'description' => 'sometimes|string',
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
            'disaster_level' => 'sometimes|in:low,medium,high,very_high',
        ]);

        $disaster->update($data);

        return response()->json([
            'message' => 'DisasterPoint updated successfully',
            'data' => $disaster->fresh(),
        ]);
    }

    public function destroy($id)
    {
        $data = DisasterPoint::find($id);
        $data->delete();

        return response()->json(['message' => 'DisasterPoint request deleted']);
    }
}
