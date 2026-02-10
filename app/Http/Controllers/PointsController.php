<?php

namespace App\Http\Controllers;

use App\Models\DisasterPoint;
use App\Models\SafePoint;
use App\Models\Sos;
use Illuminate\Http\Request;

class PointsController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');

        return response()->json([
            'message' => 'Points retrieved',
            'data' => [
                'disaster_points' =>
                    $type === null || $type === 'disaster'
                        ? DisasterPoint::query()->get()
                        : [],
                'safe_points' =>
                    $type === null || $type === 'safe'
                        ? SafePoint::query()->get()
                        : [],
            ],
        ]);
    }

    public function overView()
    {
        $totalDisasters = DisasterPoint::count();
        $totalSafePoints = SafePoint::count();
        $totalSosRequests = Sos::count();

        $safePointResources = [
            'sufficient' => SafePoint::where('status', 'sufficient')->count(),
            'insufficient' => SafePoint::where('status', 'insufficient')->count(),
            'critical' => SafePoint::where('status', 'critical')->count(),
        ];

        $recentSosRequests = Sos::latest()
            ->take(5)
            ->get([
                'id',
                'description',
                'created_at',
                'latitude',
                'longitude',
            ]);

        return response()->json([
            'totals' => [
                'disaster_points' => $totalDisasters,
                'safe_points' => $totalSafePoints,
                'sos_requests' => $totalSosRequests,
            ],
            'safe_point_resources' => $safePointResources,
            'recent_sos_requests' => $recentSosRequests,
        ]);
    }
}
