<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachable;
use Illuminate\Http\Request;

class AttachableController extends Controller
{
    /**
     * List all attachments
     */
    public function index()
    {
        return response()->json([
            'data' => Attachable::latest()->get()
        ]);
    }

    /**
     * Store a new attachment
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'attachable_id' => 'required|integer',
            'attachable_type' => 'required|string',
            'path' => 'required|string',
            'type' => 'nullable|string',
        ]);

        $attachment = Attachable::create($data);

        return response()->json([
            'message' => 'Attachment created successfully',
            'data' => $attachment
        ], 201);
    }

    /**
     * Show a single attachment
     */
    public function show($id)
    {
        $attachment = Attachable::findOrFail($id);

        return response()->json([
            'data' => $attachment
        ]);
    }

    /**
     * Update an attachment
     */
    public function update(Request $request, $id)
    {
        $attachment = Attachable::findOrFail($id);

        $data = $request->validate([
            'path' => 'sometimes|required|string',
            'type' => 'sometimes|nullable|string',
        ]);

        $attachment->update($data);

        return response()->json([
            'message' => 'Attachment updated successfully',
            'data' => $attachment
        ]);
    }

    /**
     * Delete an attachment
     */
    public function destroy($id)
    {
        $attachment = Attachable::findOrFail($id);
        $attachment->delete();

        return response()->json([
            'message' => 'Attachment deleted successfully'
        ]);
    }
}
