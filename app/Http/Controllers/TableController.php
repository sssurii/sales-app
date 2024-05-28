<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableStoreRequest;
use App\Http\Requests\TableUpdateRequest;
use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TableController extends Controller
{
    public function index(Request $request): View
    {
        $tables = Table::all();

        return view('tables.index', compact('tables'));
    }

    public function store(TableStoreRequest $request): RedirectResponse
    {
        $table = Table::create($request->validated());

        $request->session()->flash(table.table_number + ' table created successfully!', $table->table_number + ' table created successfully!');

        return redirect()->route('tables.index');
    }

    public function show(Request $request, Table $table): View
    {
        $tables = Table::find(id)->get();

        return view('tables.show', compact('table'));
    }

    public function update(TableUpdateRequest $request, Table $table): RedirectResponse
    {
        $tables = Table::find(id)->get();


        $table->save();

        $request->session()->flash(table.table_number + ' table updated successfully!', $table->table_number + ' table updated successfully!');

        return redirect()->route('tables.show', [$table]);
    }

    public function destroy(Request $request, Table $table): RedirectResponse
    {
        $tables = Table::find(id)->get();

        $table->delete();

        $request->session()->flash(table.table_number + ' table deleted successfully!', $table->table_number + ' table deleted successfully!');

        return redirect()->route('tables.index');
    }
}
