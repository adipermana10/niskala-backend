<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Disaster;
use App\Models\Donation;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_collected'  => Donation::where('status', 'verified')->sum('amount'),
            'total_campaigns'  => Campaign::count(),
            'active_campaigns' => Campaign::where('status', 'active')->count(),
            'total_disasters'  => Disaster::count(),
            'total_donors'     => Donation::where('status', 'verified')->count(),
            'total_users'      => User::count(),
            'total_categories' => Category::count(),
        ];

        $recentDonations = Donation::with('campaign')
            ->latest()
            ->take(6)
            ->get();

        $urgentCampaigns = Campaign::with('category')
            ->where('status', 'active')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentDonations', 'urgentCampaigns'));
    }
}