<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Disaster;
use Illuminate\Http\Request;

class DisasterInfoController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $query = Disaster::with('category')->latest('occurred_at');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('location', 'ilike', "%{$search}%")
                  ->orWhere('summary', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil semua hasil sesuai filter untuk ditampilkan di Peta Interaktif
        $mapDisasters = (clone $query)->get()->map(function ($d) {
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

        $disasters = $query->paginate(9)->withQueryString();

        return view('pages.disasters.index', compact('disasters', 'categories', 'mapDisasters'));
    }

    public function show(string $slug)
    {
        $disaster = Disaster::with([
            'category',
            'campaigns' => function ($query) {
                $query->where('status', 'active')->latest();
            },
        ])->where('slug', $slug)->firstOrFail();

        $otherDisasters = Disaster::with('category')
            ->where('id', '!=', $disaster->id)
            ->latest('occurred_at')
            ->get()
            ->map(function ($d) {
                return [
                    'id'               => $d->id,
                    'title'            => $d->title,
                    'category'         => $d->category->name ?? 'Bencana Alam',
                    'location'         => $d->location,
                    'latitude'         => (float) $d->latitude,
                    'longitude'        => (float) $d->longitude,
                    'impact_radius_km' => (float) $d->impact_radius_km,
                    'status_label'     => $d->status_label,
                    'occurred_at'      => $d->occurred_at->translatedFormat('d M Y, H:i') . ' WIB',
                    'url'              => route('disasters.show', $d->slug),
                ];
            });

        return view('pages.disasters.show', compact('disaster', 'otherDisasters'));
    }
}