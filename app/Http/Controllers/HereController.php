<?php

namespace App\Http\Controllers;

use App\Models\Here;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HereController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Here::latest();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('title', fn($row) => e($row->title))
                ->addColumn('button', fn($row) => e($row->button))
                ->addColumn('description', fn($row) => Str::limit(strip_tags($row->description), 100))
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.here.edit', $row->id);

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

        return view('admin.here.index');
    }

    public function create()
    {
        return view('admin.here.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button' => 'nullable|string|max:255',
        ]);

        Here::create($validated);

        return redirect()->route('admin.here.index')
            ->with('success', 'Here created successfully');
    }

    public function edit($id)
    {
        $here = Here::findOrFail($id);

        return view('admin.here.edit', compact('here'));
    }

    public function update(Request $request, $id)
    {
        $here = Here::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button' => 'nullable|string|max:255',
        ]);

        $here->update($validated);

        return redirect()->route('admin.here.index')
            ->with('success', 'Here updated successfully');
    }

    public function destroy($id)
    {
        $here = Here::findOrFail($id);
        $here->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Here deleted successfully',
        ]);
    }
}
