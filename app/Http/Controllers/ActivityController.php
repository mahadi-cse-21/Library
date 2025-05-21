<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::latest()->with(['user', 'book', 'student']);
        
        // Filter by type if provided
        if ($request->has('type') && $request->type !== 'all') {
            $query->ofType($request->type);
        }
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('book', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  })
                  ->orWhereHas('student', function($q) use ($search) {
                      $q->where('student_id', 'like', "%{$search}%");
                  });
            });
        }
        
        $activities = $query->paginate(15);
        
        return view('admin.activities.index', [
            'activities' => $activities,
            'types' => [
                'all' => 'All Activities',
                'borrow' => 'Borrowings',
                'return' => 'Returns',
                'request' => 'Requests',
                'overdue' => 'Overdue Notices'
            ]
        ]);
    }
    
    /**
     * Get recent activities for dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecentActivities($limit = 10)
    {
        $activities = Activity::latest()
                            ->with(['user', 'book', 'student'])
                            ->limit($limit)
                            ->get();
                            
        $total_activities = Activity::count();
        
        return [
            'activities' => $activities,
            'total_activities' => $total_activities
        ];
    }
}
