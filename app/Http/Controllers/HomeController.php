<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get user statistics
        $stats = [
            'total_orders' => $this->getUserOrderCount($user->id),
            'active_projects' => $this->getActiveProjectsCount($user->id),
            'unread_messages' => $this->getUnreadMessagesCount($user->id),
            'profile_completion' => $this->calculateProfileCompletion($user),
        ];
        
        // Get recent activities
        $activities = $this->getRecentActivities($user->id);
        
        return view('user.dashboard', [
            'stats' => $stats,
            'activities' => $activities,
            'user' => $user
        ]);
    }
    
    /**
     * Get user's total order count
     */
    protected function getUserOrderCount($userId)
    {
        // Check if orders table exists
        if (!\Schema::hasTable('orders')) {
            return 0;
        }
        
        return DB::table('orders')
            ->where('user_id', $userId)
            ->count();
    }
    
    /**
     * Get user's active projects count
     */
    protected function getActiveProjectsCount($userId)
    {
        // Check if projects table exists
        if (!\Schema::hasTable('projects')) {
            return 0;
        }
        
        return DB::table('projects')
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->count();
    }
    
    /**
     * Get user's unread messages count
     */
    protected function getUnreadMessagesCount($userId)
    {
        // Check if messages table exists
        if (!\Schema::hasTable('messages')) {
            return 0;
        }
        
        return DB::table('messages')
            ->where('recipient_id', $userId)
            ->where('read_at', null)
            ->count();
    }
    
    /**
     * Calculate user's profile completion percentage
     */
    protected function calculateProfileCompletion($user)
    {
        $totalFields = 5; // email, name, created_at, updated_at, role
        $completedFields = 2; // email and name are always filled
        
        // Add more fields as needed
        $fieldsToCheck = [
            'phone', 'address', 'city', 'country', 'postal_code',
            'bio', 'avatar', 'website', 'company', 'job_title'
        ];
        
        foreach ($fieldsToCheck as $field) {
            if (isset($user->$field) && !empty($user->$field)) {
                $completedFields++;
                $totalFields++;
            } elseif (in_array($field, ['phone', 'address'])) {
                $totalFields++; // Only count these as required fields
            }
        }
        
        return min(100, (int) (($completedFields / $totalFields) * 100));
    }
    
    /**
     * Get user's recent activities
     */
    protected function getRecentActivities($userId)
    {
        $activities = [];
        
        // Add user creation as the first activity
        $user = User::find($userId);
        if ($user) {
            $activities[] = [
                'type' => 'account_created',
                'title' => 'Account Created',
                'description' => 'Your account was created successfully',
                'time' => $user->created_at,
                'icon' => 'person-plus',
                'color' => 'primary'
            ];
        }
        
        // Add login activity
        $activities[] = [
            'type' => 'login',
            'title' => 'Last Login',
            'description' => 'You logged in successfully',
            'time' => $user->last_login_at ?? now(),
            'icon' => 'box-arrow-in-right',
            'color' => 'success'
        ];
        
        // Add more activities from activity logs if available
        if (\Schema::hasTable('activity_log')) {
            $logs = DB::table('activity_log')
                ->where('causer_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
                
            foreach ($logs as $log) {
                $activities[] = [
                    'type' => $log->log_name ?? 'activity',
                    'title' => ucwords(str_replace('_', ' ', $log->log_name ?? 'Activity')),
                    'description' => $log->description ?? 'Activity performed',
                    'time' => $log->created_at,
                    'icon' => 'activity',
                    'color' => 'info'
                ];
            }
        }
        
        // Sort activities by time
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        
        return array_slice($activities, 0, 3); // Return only the 3 most recent activities
    }
}
