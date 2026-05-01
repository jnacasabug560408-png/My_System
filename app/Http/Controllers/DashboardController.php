<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\User;
use App\Models\Comment;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. ADMIN DASHBOARD LOGIC
        if ($user->isAdmin()) {
            $totalUsers = User::count();
            $totalContent = Content::count();
            $totalComments = Comment::count();
            $pendingComments = Comment::where('status', 'pending')->count();
            $totalMedia = Media::count();
            $recentUsers = User::latest()->limit(5)->get();
            $recentContent = Content::latest()->limit(5)->get();
            $pendingComments_list = Comment::where('status', 'pending')->latest()->limit(10)->get();

            return view('dashboard', compact(
                'totalUsers', 'totalContent', 'totalComments', 'pendingComments',
                'totalMedia', 'recentUsers', 'recentContent', 'pendingComments_list'
            ));
        } 
        
        // 2. SUBSCRIBER DASHBOARD LOGIC
        elseif ($user->role === 'subscriber') {
            // Count only THIS subscriber's comments
            $myComments = Comment::where('user_id', $user->id)->count();
            
            // Subscribers see ALL published posts from the entire site
            $recentContent = Content::where('status', 'published')
                                    ->latest()
                                    ->limit(5)
                                    ->get();

            // Set these to 0 as subscribers don't write articles
            $myContent = 0;
            $myDrafts = 0;
            $myPublished = 0;

            return view('dashboard', compact(
                'myContent', 'myDrafts', 'myPublished', 'myComments', 'recentContent'
            ));
        }

        // 3. EDITOR DASHBOARD LOGIC
        else {
            $myContent = $user->contents()->count();
            $myDrafts = $user->contents()->where('status', 'draft')->count();
            $myPublished = $user->contents()->where('status', 'published')->count();
            $myComments = Comment::where('user_id', $user->id)->count();
            
            // Editors see only the content they created
            $recentContent = $user->contents()->latest()->limit(5)->get();

            return view('dashboard', compact(
                'myContent', 'myDrafts', 'myPublished', 'myComments', 'recentContent'
            ));
        }
    }

    public function analytics()
    {
        $this->authorize('admin');

        $contentStats = Content::selectRaw('status, count(*) as total')->groupBy('status')->get();
        $userStats = User::selectRaw('role, count(*) as total')->groupBy('role')->get();
        $commentStats = Comment::selectRaw('status, count(*) as total')->groupBy('status')->get();
        $contentByCategory = Content::selectRaw('category_id, count(*) as total')
            ->groupBy('category_id')->with('category')->get();
        $topAuthors = User::withCount('contents')->orderByDesc('contents_count')->limit(10)->get();

        return view('admin.analytics', compact(
            'contentStats', 'userStats', 'commentStats', 'contentByCategory', 'topAuthors'
        ));
    }

    public function reports()
    {
        $this->authorize('admin');

        $totalContent = Content::count();
        $publishedContent = Content::where('status', 'published')->count();
        $draftContent = Content::where('status', 'draft')->count();
        $hiddenContent = Content::where('status', 'hidden')->count();
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();
        $totalComments = Comment::count();
        $approvedComments = Comment::where('status', 'approved')->count();
        $pendingComments = Comment::where('status', 'pending')->count();
        $spamComments = Comment::where('status', 'spam')->count();
        $totalViews = Content::sum('views');
        $averageViews = Content::avg('views');
        $topPosts = Content::orderByDesc('views')->limit(10)->get();

        return view('admin.reports', compact(
            'totalContent', 'publishedContent', 'draftContent', 'hiddenContent',
            'totalUsers', 'activeUsers', 'inactiveUsers', 'totalComments',
            'approvedComments', 'pendingComments', 'spamComments',
            'totalViews', 'averageViews', 'topPosts'
        ));
    }
}