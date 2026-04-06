<?php

namespace App\Http\Controllers;

use App\Models\Future;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FutureController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Future::latest();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('title', fn($row) => e($row->title))
                ->addColumn('tagline', fn($row) => e($row->tagline))
                ->addColumn('button', fn($row) => e($row->button))
                ->addColumn('description', fn($row) => Str::limit(strip_tags($row->description), 100))
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.future.edit', $row->id);

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

        return view('admin.future.index');
    }

    public function create()
    {
        return view('admin.future.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
        ]);

        Future::create($validated);

        return redirect()->route('admin.future.index')
            ->with('success', 'Future created successfully');
    }

    public function edit($id)
    {
        $future = Future::findOrFail($id);

        return view('admin.future.edit', compact('future'));
    }

    public function update(Request $request, $id)
    {
        $future = Future::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
        ]);

        $future->update($validated);

        return redirect()->route('admin.future.index')
            ->with('success', 'Future updated successfully');
    }

    public function destroy($id)
    {
        $future = Future::findOrFail($id);
        $future->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Future deleted successfully',
        ]);
    }
}
