<?php

namespace App\Http\Controllers;

use App\Models\SafePoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SafePointController extends Controller
{
    public function index()
    {
        $safe = SafePoint::with('resources')->get();
        return response()->json(['message' => 'All SafePoint requests retrieved', 'data' => $safe]);
    }

    public function show($id)
    {
        $safe = SafePoint::with('resources')->find($id);
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
            'resource_type' => 'required|in:clothes,food,medical_supplies,water,others',
            'resource_description' => 'nullable|string',
        ]);

        $safePoint = DB::transaction(function () use ($data) {
            $safePoint = SafePoint::create([
                'name' => $data['name'],
                'type' => $data['type'],
                'capacity' => $data['capacity'],
                'status' => $data['status'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);

            $safePoint->resources()->create([
                'type' => $data['resource_type'],
                'description' => $data['resource_description'] ?? null,
            ]);

            return $safePoint;
        });

        return response()->json([
            'message' => 'Safe point created successfully',
            'data' => $safePoint->load('resources'),
        ], 201);
    }

    public function update(Request $request, SafePoint $safePoint)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:shelter,food_distribution,medical_camp',
            'capacity' => 'sometimes|integer|min:0',
            'status' => 'sometimes|in:sufficient,insufficient,critical',
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
            'resource_type' => 'sometimes|in:clothes,food,medical_supplies,water,others',
            'resource_description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($safePoint, $data) {
            $safePoint->update(collect($data)->only([
                'name',
                'type',
                'capacity',
                'status',
                'latitude',
                'longitude',
            ])->toArray());

            if (
                array_key_exists('resource_type', $data) ||
                array_key_exists('resource_description', $data)
            ) {
                $safePoint->resource()->updateOrCreate(
                    [],
                    [
                        'type' => $data['resource_type'] ?? $safePoint->resource?->type,
                        'description' => $data['resource_description'] ?? $safePoint->resource?->description,
                    ]
                );
            }
        });

        return response()->json([
            'message' => 'Safe point updated successfully',
            'data' => $safePoint->load('resource'),
        ]);
    }

    public function destroy($id)
    {
        $data = SafePoint::find($id);
        $data->delete();

        return response()->json(['message' => 'SafePoint request deleted']);
    }
}
