<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Disaster;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DisasterController extends Controller
{
    public function index()
    {
        $disasters = Disaster::with('category')->latest('occurred_at')->paginate(10);
        return view('admin.disasters.index', compact('disasters'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.disasters.form', [
            'disaster'   => new Disaster([
                'latitude'         => -7.5407170,
                'longitude'        => 110.4457240,
                'impact_radius_km' => 10.00,
                'status'           => 'tanggap_darurat',
            ]),
            'categories' => $categories,
            'isEdit'     => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'      => ['required', 'exists:categories,id'],
            'title'            => ['required', 'string', 'max:200'],
            'location'         => ['required', 'string', 'max:150'],
            'latitude'         => ['required', 'numeric', 'between:-90,90'],
            'longitude'        => ['required', 'numeric', 'between:-180,180'],
            'impact_radius_km' => ['required', 'numeric', 'min:0.1', 'max:500'],
            'occurred_at'      => ['required', 'date'],
            'status'           => ['required', 'in:siaga,tanggap_darurat,pemulihan,selesai'],
            'summary'          => ['required', 'string', 'max:600'],
            'content'          => ['required', 'string'],
            'thumbnail'        => ['nullable', 'url', 'max:500'],
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::lower(Str::random(4));

        Disaster::create($validated);

        return redirect()->route('admin.disasters.index')->with('success', 'Data lokasi, radius dampak, dan laporan bencana berhasil disimpan.');
    }

    public function edit(Disaster $disaster)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.disasters.form', [
            'disaster'   => $disaster,
            'categories' => $categories,
            'isEdit'     => true,
        ]);
    }

    public function update(Request $request, Disaster $disaster)
    {
        $validated = $request->validate([
            'category_id'      => ['required', 'exists:categories,id'],
            'title'            => ['required', 'string', 'max:200'],
            'location'         => ['required', 'string', 'max:150'],
            'latitude'         => ['required', 'numeric', 'between:-90,90'],
            'longitude'        => ['required', 'numeric', 'between:-180,180'],
            'impact_radius_km' => ['required', 'numeric', 'min:0.1', 'max:500'],
            'occurred_at'      => ['required', 'date'],
            'status'           => ['required', 'in:siaga,tanggap_darurat,pemulihan,selesai'],
            'summary'          => ['required', 'string', 'max:600'],
            'content'          => ['required', 'string'],
            'thumbnail'        => ['nullable', 'url', 'max:500'],
        ]);

        $disaster->update($validated);

        return redirect()->route('admin.disasters.index')->with('success', 'Perubahan lokasi, radius dampak, dan informasi bencana berhasil disimpan.');
    }

    public function destroy(Disaster $disaster)
    {
        $disaster->delete();
        return redirect()->route('admin.disasters.index')->with('success', 'Laporan bencana alam berhasil dihapus.');
    }
}