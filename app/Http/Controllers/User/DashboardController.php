<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $donations = Donation::with('campaign.category')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('donor_email', $user->email);
            })
            ->latest()
            ->paginate(10);

        $stats = [
            'total_amount'    => Donation::where('user_id', $user->id)->where('status', 'verified')->sum('amount'),
            'total_donations' => Donation::where('user_id', $user->id)->count(),
            'campaigns_count' => Donation::where('user_id', $user->id)->distinct('campaign_id')->count('campaign_id'),
        ];

        return view('user.dashboard', compact('user', 'donations', 'stats'));
    }
}