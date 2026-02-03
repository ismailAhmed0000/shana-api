<?php

namespace App\Http\Controllers;

use App\Models\DisasterPoint;
use Illuminate\Http\Request;

class DisatserController extends Controller
{
    public function index()
    {
        $disaster = DisasterPoint::get();
        return response()->json(['message' => 'All sos requests retrieved', 'data' => $disaster]);
    }

    public function show($id)
    {
        $disaster = DisasterPoint::find($id);
        return response()->json(['message' => 'Sos request retrieved ', 'data' => $disaster]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $disaster = DisasterPoint::create($data);

        return response()->json(['message' => 'Sos request created successflyy', 'data' => $disaster]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'description' => 'sometimes|string|max:255',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
        ]);

        $disaster = DisasterPoint::update($data);

        return response()->json(['message' => 'Sos request created successflyy', 'data' => $disaster]);
    }

    public function destroy($id)
    {
        $data = DisasterPoint::find($id);
        $data->delete();

        return response()->json(['message' => 'Sos request deleted']);
    }
}
