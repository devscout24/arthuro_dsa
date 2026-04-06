<?php

namespace App\Http\Controllers;

use App\Models\CarrerUp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarrerUpController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CarrerUp::latest();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('title', fn($row) => e($row->title))
                ->addColumn('description', fn($row) => Str::limit(strip_tags($row->description), 100))
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.carrer_up.edit', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.carrer_up.index');
    }

    public function create()
    {
        return view('admin.carrer_up.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        CarrerUp::create($validated);

        return redirect()->route('admin.carrer_up.index')
            ->with('success', 'Carrer Up created successfully');
    }

    public function edit($id)
    {
        $carrerUp = CarrerUp::findOrFail($id);
        return view('admin.carrer_up.edit', compact('carrerUp'));
    }

    public function update(Request $request, $id)
    {
        $carrerUp = CarrerUp::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $carrerUp->update($validated);

        return redirect()->route('admin.carrer_up.index')
            ->with('success', 'Carrer Up updated successfully');
    }

    public function destroy($id)
    {
        $carrerUp = CarrerUp::findOrFail($id);
        $carrerUp->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Carrer Up deleted successfully'
        ]);
    }
}
