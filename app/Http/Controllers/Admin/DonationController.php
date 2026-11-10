<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with('campaign')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $donations = $query->paginate(15)->withQueryString();

        return view('admin.donations.index', compact('donations'));
    }

    public function updateStatus(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,verified,rejected'],
        ]);

        DB::transaction(function () use ($donation, $validated) {
            $oldStatus = $donation->status;
            $newStatus = $validated['status'];

            if ($oldStatus === $newStatus) {
                return;
            }

            // Rekalkulasi dana terkumpul pada kampanye terkait secara akurat
            if ($oldStatus !== 'verified' && $newStatus === 'verified') {
                $donation->campaign()->increment('collected_amount', $donation->amount);
                $donation->verified_at = now();
            } elseif ($oldStatus === 'verified' && $newStatus !== 'verified') {
                $donation->campaign()->decrement('collected_amount', $donation->amount);
                $donation->verified_at = null;
            }

            $donation->status = $newStatus;
            $donation->save();
        });

        return back()->with('success', 'Status donasi #' . $donation->invoice_number . ' berhasil diperbarui.');
    }

    public function destroy(Donation $donation)
    {
        DB::transaction(function () use ($donation) {
            if ($donation->status === 'verified') {
                $donation->campaign()->decrement('collected_amount', $donation->amount);
            }
            $donation->delete();
        });

        return back()->with('success', 'Data donasi berhasil dihapus.');
    }
}