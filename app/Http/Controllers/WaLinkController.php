<?php

namespace App\Http\Controllers;

use App\Models\WaLink;
use Illuminate\Http\Request;

class WaLinkController extends Controller
{
    public function index()
    {
        $links = WaLink::all()->keyBy('type');
        return view('admin.wa.index', compact('links'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'link_eligible' => 'required|url',
            'link_cadangan' => 'required|url',
        ]);

        WaLink::updateOrCreate(['type' => 'eligible'], ['link' => $request->link_eligible]);
        WaLink::updateOrCreate(['type' => 'cadangan'], ['link' => $request->link_cadangan]);

        return redirect()->back()->with('success', 'Link WA berhasil diperbarui!');
    }
}
