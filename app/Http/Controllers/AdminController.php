<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getNgos()
    {
        $ngo = User::where('approved', true)->all();
        return response()->json(['message' => 'Ngos retrieved', 'data' => $ngo]);
    }

    public function approve(Request $request, User $user)
    {
        $data = $request->validate(['approved' => 'required', 'boolean']);

        $user->update(['approved' => $data['approved']]);
        return response()->json(['message' => 'Ngo approved', $user]);
    }
}
