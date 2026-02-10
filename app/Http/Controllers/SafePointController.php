<?php

namespace App\Http\Controllers;

use App\Models\SafePoint;
use Illuminate\Http\Request;

class SafePointController extends Controller
{
    public function index()
    {
        $safe = SafePoint::get();
        return response()->json(['message' => 'All SafePoint requests retrieved', 'data' => $safe]);
    }

    public function show($id)
    {
        $safe = SafePoint::find($id);
        return response()->json(['message' => 'SafePoint request retrieved ', 'data' => $safe]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:shelter,food_distribution,medical_camp',
            'capacity' => 'required|integer|min:0',
            'status' => 'required|in:sufficient,insufficient,critical',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $safePoint = SafePoint::create($data);

        return response()->json([
            'message' => 'Safe point created successfully',
            'data' => $safePoint,
        ], 201);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:shelter,food_distribution,medical_camp',
            'capacity' => 'sometimes|integer|min:0',
            'status' => 'sometimes|in:sufficient,insufficient,critical',
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
        ]);

        $safe = SafePoint::update($data);

        return response()->json(['message' => 'SafePoint request created successflyy', 'data' => $safe]);
    }

    public function destroy($id)
    {
        $data = SafePoint::find($id);
        $data->delete();

        return response()->json(['message' => 'SafePoint request deleted']);
    }
}
