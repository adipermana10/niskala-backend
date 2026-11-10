<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Menampilkan daftar kampanye dengan fitur pencarian, filter kategori, dan pengurutan
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $query = Campaign::with(['category', 'disaster', 'author'])
            ->whereIn('status', ['active', 'completed']);

        // Pencarian berdasarkan judul atau deskripsi
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        // Filter berdasarkan slug kategori
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Pengurutan (Sorting)
        $sort = $request->get('sort', 'latest');
        if ($sort === 'urgent') {
            $query->whereNotNull('deadline')
                  ->where('deadline', '>=', now()->toDateString())
                  ->orderBy('deadline', 'asc');
        } elseif ($sort === 'popular') {
            $query->orderBy('collected_amount', 'desc');
        } else {
            $query->latest();
        }

        $campaigns = $query->paginate(9)->withQueryString();

        return view('pages.campaigns.index', compact('campaigns', 'categories'));
    }

    /**
     * Menampilkan detail kampanye, progres donasi, form donasi, dan daftar donatur
     */
    public function show(string $slug)
    {
        $campaign = Campaign::with([
            'category',
            'disaster',
            'author',
            'verifiedDonations' => function ($query) {
                $query->latest();
            },
        ])->where('slug', $slug)->firstOrFail();

        $relatedCampaigns = Campaign::with('category')
            ->where('status', 'active')
            ->where('id', '!=', $campaign->id)
            ->where('category_id', $campaign->category_id)
            ->take(3)
            ->get();

        return view('pages.campaigns.show', compact('campaign', 'relatedCampaigns'));
    }

    /**
     * Memproses penyimpanan donasi baru pada kampanye
     */
    public function donate(Request $request, string $slug)
    {
        $campaign = Campaign::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $validated = $request->validate([
            'donor_name'     => ['required', 'string', 'max:100'],
            'donor_email'    => ['nullable', 'email', 'max:150'],
            'amount'         => ['required', 'numeric', 'min:10000', 'max:500000000'],
            'payment_method' => ['required', 'string', 'max:50'],
            'message'        => ['nullable', 'string', 'max:500'],
            'is_anonymous'   => ['nullable', 'boolean'],
        ], [
            'donor_name.required' => 'Nama donatur wajib diisi.',
            'amount.required'     => 'Nominal donasi wajib diisi.',
            'amount.min'          => 'Minimal donasi adalah Rp 10.000.',
        ]);

        DB::transaction(function () use ($validated, $campaign, $request) {
            $invoiceNumber = 'NSK-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

            Donation::create([
                'campaign_id'    => $campaign->id,
                'user_id'        => Auth::id(),
                'invoice_number' => $invoiceNumber,
                'donor_name'     => $validated['donor_name'],
                'donor_email'    => $validated['donor_email'] ?? (Auth::user()->email ?? null),
                'is_anonymous'   => $request->boolean('is_anonymous'),
                'amount'         => $validated['amount'],
                'message'        => $validated['message'] ?? null,
                'payment_method' => $validated['payment_method'],
                'status'         => 'verified',
                'verified_at'    => now(),
            ]);

            // Tambahkan ke dana terkumpul kampanye
            $campaign->increment('collected_amount', $validated['amount']);
        });

        return redirect()
            ->route('campaigns.show', $campaign->slug)
            ->with('success', 'Terima kasih! Donasi dan doa kebaikan Anda telah tercatat di Niskala.');
    }
}