<?php

namespace App\Http\Controllers;

use App\Models\TeamParagraph;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamParagraphController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = TeamParagraph::latest()->get();

            return datatables()->of($items)
                ->addIndexColumn()
                ->addColumn('title', fn ($item) => $item->title)
                ->addColumn('tagline', fn ($item) => $item->tagline)
                ->addColumn('description', fn ($item) => Str::limit(strip_tags($item->description), 80))
                ->addColumn('action', function ($item) {
                    $editUrl = route('admin.team_paragraph.edit', $item->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete" data-id="' . $item->id . '">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.team_paragraph.index');
    }

    public function create()
    {
        return view('admin.team_paragraph.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'required',
        ]);

        TeamParagraph::create($validated);

        return redirect()->route('admin.team_paragraph.index')
            ->with('success', 'Team paragraph created successfully');
    }

    public function edit($id)
    {
        $item = TeamParagraph::findOrFail($id);

        return view('admin.team_paragraph.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = TeamParagraph::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'required',
        ]);

        $item->update($validated);

        return redirect()->route('admin.team_paragraph.index')
            ->with('success', 'Team paragraph updated successfully');
    }

    public function destroy($id)
    {
        $item = TeamParagraph::findOrFail($id);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Team paragraph deleted successfully'
        ]);
    }
}
