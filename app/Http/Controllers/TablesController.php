<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;

class TablesController extends Controller
{
    public function index()
    {
        $table = Table::all();

        return view('pages.table.index', ['table' => $table]);
    }

    public function create()
    {
        return view('pages.table.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'table' => 'required|string|max:255',
        ]);

        $table = Table::create([
            'nomor_meja' => $validatedData['table'],
            'status' => 'Available',
        ]);

        return redirect()->route('list-table')->with('success', 'User successfully created.');
    }

    public function edit($id)
    {
        $table = Table::findOrFail($id);
        return view('pages.table.edit', compact('table'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_meja' => 'required',
        ]);

        $table = Table::findOrFail($id);

        $table->nomor_meja = $request->nomor_meja;


        $table->save();

        return redirect()->route('list-table')->with('success', 'Table updated successfully');
    }

    public function reservation(Request $request, $id)
    {
        $table = Table::findOrFail($id);

        $table->status = 'Reserved';
        $table->dipesan_oleh = $request->nama_pemesan;

        $table->save();

        return redirect()->route('list-table')->with('success', 'Table updated successfully');
    }

    public function cancelReservation($id)
    {
        $table = Table::findOrFail($id);

        $table->status = 'Available';
        $table->dipesan_oleh = null;

        $table->save();

        return redirect()->route('list-table')->with('success', 'Table updated successfully');
    }

    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return redirect()->route('list-table')->with('success', 'Table deleted successfully');
    }
}
