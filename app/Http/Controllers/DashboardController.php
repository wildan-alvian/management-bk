<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counseling;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isStudent = $user->hasRole('Student');
        $isParent = $user->hasRole('Student Parents');
        $isGuidanceCounselor = $user->hasRole('Guidance Counselor');
        $isAdmin = $user->hasRole(['Super Admin', 'Admin']);

        // Base query conditions
        $baseQuery = function() use ($user, $isStudent, $isParent) {
            $query = Counseling::query();
            if ($isStudent || $isParent) {
                $query->where('submitted_by_id', $user->id);
            }
            return $query;
        };

        // Get counseling statistics
        $totalCounseling = $baseQuery()->count();
        $newCounseling = $baseQuery()->where('status', 'new')->count();
        $approvedCounseling = $baseQuery()->where('status', 'approved')->count();
        $rejectedCounseling = $baseQuery()->where('status', 'rejected')->count();

        // Get monthly counseling data for the current year
        $monthlyData = $baseQuery()
            ->select(
                DB::raw('MONTH(created_at) as month_number'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month_number')
            ->get();

        // Format data for chart
        $months = [];
        $counselingCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->format('F');
            $monthData = $monthlyData->firstWhere('month_number', $i);
            $counselingCounts[] = $monthData ? $monthData->total : 0;
        }

        // Get counseling type distribution (only for Admin and Guidance Counselor)
        $counselingTypes = null;
        if ($isAdmin || $isGuidanceCounselor) {
            $counselingTypes = $baseQuery()
                ->select('counseling_type', DB::raw('COUNT(*) as total'))
                ->groupBy('counseling_type')
                ->get();
        }

        // Get recent counseling requests
        $recentCounseling = $baseQuery()
            ->with('submittedByUser')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get total users by role (only for Admin)
        $usersByRole = null;
        if ($isAdmin) {
            $usersByRole = [
                'counselors' => User::role('Guidance Counselor')->count(),
                'students' => User::role('Student')->count(),
                'parents' => User::role('Student Parents')->count(),
            ];
        }

        return view('dashboard.index', compact(
            'totalCounseling',
            'newCounseling',
            'approvedCounseling',
            'rejectedCounseling',
            'months',
            'counselingCounts',
            'counselingTypes',
            'recentCounseling',
            'usersByRole',
            'isAdmin',
            'isGuidanceCounselor',
            'isStudent',
            'isParent'
        ));
    }
} 