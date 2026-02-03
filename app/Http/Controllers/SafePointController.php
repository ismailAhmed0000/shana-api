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
            'description' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $safe = SafePoint::create($data);

        return response()->json(['message' => 'SafePoint request created successflyy', 'data' => $safe]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'description' => 'sometimes|string|max:255',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
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
