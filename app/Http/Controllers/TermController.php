<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TermController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $terms = Term::latest();

            return datatables()->of($terms)
                ->addIndexColumn()
                ->addColumn('description', function ($term) {
                    return Str::limit(strip_tags($term->description), 80);
                })
                ->addColumn('action', function ($term) {
                    $editUrl = route('admin.term.edit', $term->id);
                    return '<a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1"><i class="fa fa-edit"></i></a>' .
                        '<button class="btn btn-danger btn-sm delete" data-id="' . $term->id . '"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.term.index');
    }

    public function create()
    {
        return view('admin.term.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Term::create($request->only('title', 'description'));

        return redirect()->route('admin.term.index')->with('success', 'Term created successfully');
    }

    public function edit($id)
    {
        $term = Term::findOrFail($id);
        return view('admin.term.edit', compact('term'));
    }

    public function update(Request $request, $id)
    {
        $term = Term::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $term->update($request->only('title', 'description'));

        return redirect()->route('admin.term.index')->with('success', 'Term updated successfully');
    }

    public function destroy($id)
    {
        try {
            $term = Term::findOrFail($id);
            $term->delete();

            return response()->json(['success' => true, 'message' => 'Term deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

