<?php

namespace App\Http\Controllers;

use App\Models\Sos;
use Illuminate\Http\Request;

class SosController extends Controller
{
    public function index()
    {
        $sos = Sos::get();
        return response()->json(['message' => 'All sos requests retrieved', 'data' => $sos]);
    }

    public function show($id)
    {
        $sos = Sos::find($id);
        return response()->json(['message' => 'Sos request retrieved ', 'data' => $sos]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $sos = Sos::create($data);

        return response()->json(['message' => 'Sos request created successflyy', 'data' => $sos]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'description' => 'sometimes|string|max:255',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
        ]);

        $sos = Sos::update($data);

        return response()->json(['message' => 'Sos request created successflyy', 'data' => $sos]);
    }

    public function destroy($id)
    {
        $data = Sos::find($id);
        $data->delete();

        return response()->json(['message' => 'Sos request deleted']);
    }
}
