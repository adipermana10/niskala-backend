<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Disaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with(['category', 'disaster', 'author'])->latest()->paginate(10);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaigns.form', [
            'campaign'   => new Campaign(),
            'categories' => Category::orderBy('name')->get(),
            'disasters'  => Disaster::orderBy('title')->get(),
            'isEdit'     => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'   => ['required', 'exists:categories,id'],
            'disaster_id'   => ['nullable', 'exists:disasters,id'],
            'title'         => ['required', 'string', 'max:200'],
            'description'   => ['required', 'string'],
            'target_amount' => ['required', 'numeric', 'min:100000'],
            'deadline'      => ['nullable', 'date'],
            'status'        => ['required', 'in:draft,active,completed,closed'],
            'thumbnail'     => ['nullable', 'url', 'max:500'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::lower(Str::random(4));
        $validated['collected_amount'] = 0;

        Campaign::create($validated);

        return redirect()->route('admin.campaigns.index')->with('success', 'Kampanye penggalangan dana berhasil dibuat.');
    }

    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.form', [
            'campaign'   => $campaign,
            'categories' => Category::orderBy('name')->get(),
            'disasters'  => Disaster::orderBy('title')->get(),
            'isEdit'     => true,
        ]);
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'category_id'   => ['required', 'exists:categories,id'],
            'disaster_id'   => ['nullable', 'exists:disasters,id'],
            'title'         => ['required', 'string', 'max:200'],
            'description'   => ['required', 'string'],
            'target_amount' => ['required', 'numeric', 'min:100000'],
            'deadline'      => ['nullable', 'date'],
            'status'        => ['required', 'in:draft,active,completed,closed'],
            'thumbnail'     => ['nullable', 'url', 'max:500'],
        ]);

        $campaign->update($validated);

        return redirect()->route('admin.campaigns.index')->with('success', 'Data kampanye berhasil diperbarui.');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return redirect()->route('admin.campaigns.index')->with('success', 'Kampanye berhasil dihapus.');
    }
}