<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Building::latest();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('title', fn($row) => e($row->title))
                ->addColumn('tagline', fn($row) => e($row->tagline))
                ->addColumn('description', fn($row) => Str::limit(strip_tags((string) $row->description), 100))
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.building.edit', $row->id);

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

        return view('admin.building.index');
    }

    public function create()
    {
        return view('admin.building.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tagline' => 'nullable|string|max:255',
        ]);

        Building::create($validated);

        return redirect()->route('admin.building.index')
            ->with('success', 'Building created successfully');
    }

    public function edit($id)
    {
        $building = Building::findOrFail($id);

        return view('admin.building.edit', compact('building'));
    }

    public function update(Request $request, $id)
    {
        $building = Building::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tagline' => 'nullable|string|max:255',
        ]);

        $building->update($validated);

        return redirect()->route('admin.building.index')
            ->with('success', 'Building updated successfully');
    }

    public function destroy($id)
    {
        $building = Building::findOrFail($id);
        $building->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Building deleted successfully'
        ]);
    }
}
