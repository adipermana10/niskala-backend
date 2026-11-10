<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Disaster;
use App\Models\Donation;

class HomeController extends Controller
{
    public function index()
    {
        $latestDisasters = Disaster::with('category')
            ->latest('occurred_at')
            ->take(3)
            ->get();

        // Data seluruh titik bencana untuk peta interaktif
        $mapDisasters = Disaster::with('category')
            ->latest('occurred_at')
            ->get()
            ->map(function ($d) {
                return [
                    'id'               => $d->id,
                    'title'            => $d->title,
                    'slug'             => $d->slug,
                    'category'         => $d->category->name ?? 'Bencana Alam',
                    'location'         => $d->location,
                    'latitude'         => (float) $d->latitude,
                    'longitude'        => (float) $d->longitude,
                    'impact_radius_km' => (float) $d->impact_radius_km,
                    'status_label'     => $d->status_label,
                    'occurred_at'      => $d->occurred_at->translatedFormat('d M Y, H:i') . ' WIB',
                    'summary'          => $d->summary,
                    'url'              => route('disasters.show', $d->slug),
                ];
            });

        $featuredCampaigns = Campaign::with(['category', 'disaster'])
            ->where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        $recentDonations = Donation::with('campaign')
            ->where('status', 'verified')
            ->whereNotNull('message')
            ->latest()
            ->take(4)
            ->get();

        $stats = [
            'total_donations'  => Donation::where('status', 'verified')->sum('amount'),
            'active_campaigns' => Campaign::where('status', 'active')->count(),
            'total_donors'     => Donation::where('status', 'verified')->count(),
            'total_disasters'  => Disaster::count(),
        ];

        $categories = Category::withCount('campaigns')->orderBy('name')->get();

        return view('pages.home', [
            'latestDisasters'   => $latestDisasters,
            'mapDisasters'      => $mapDisasters,
            'featuredCampaigns' => $featuredCampaigns,
            'recentDonations'   => $recentDonations,
            'stats'             => $stats,
            'categories'        => $categories,
        ]);
    }
}