<?php

namespace App\Http\Controllers;

use App\Models\Exception as ExceptionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExceptionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ExceptionModel::latest();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('title', fn($row) => e($row->title))
                ->addColumn('description', fn($row) => Str::limit(strip_tags($row->description), 100))
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.exception.edit', $row->id);

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

        return view('admin.exception.index');
    }

    public function create()
    {
        return view('admin.exception.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        ExceptionModel::create($validated);

        return redirect()->route('admin.exception.index')
            ->with('success', 'Exception created successfully');
    }

    public function edit($id)
    {
        $exception = ExceptionModel::findOrFail($id);
        return view('admin.exception.edit', compact('exception'));
    }

    public function update(Request $request, $id)
    {
        $exception = ExceptionModel::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $exception->update($validated);

        return redirect()->route('admin.exception.index')
            ->with('success', 'Exception updated successfully');
    }

    public function destroy($id)
    {
        $exception = ExceptionModel::findOrFail($id);
        $exception->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Exception deleted successfully'
        ]);
    }
}
