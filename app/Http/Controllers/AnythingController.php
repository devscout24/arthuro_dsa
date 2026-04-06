<?php

namespace App\Http\Controllers;

use App\Models\Anything;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnythingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $anything = Anything::latest()->get();
            return datatables()->of($anything)
                ->addIndexColumn() // This adds DT_RowIndex

                ->addColumn('title', function ($anything) {
                    return $anything->title;
                })
                ->addColumn('description', function ($anything) {
                    return Str::limit(strip_tags($anything->description), 80);
                })

                ->addColumn('tagline', function ($anything) {
                    return $anything->tagline;
                })
                ->addColumn('action', function ($anything) {
                    $editUrl = route('admin.anything.edit', $anything->id);
                    return '
                    <a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-sm delete" data-id="' . $anything->id . '">
                        <i class="fa fa-trash"></i>
                    </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.anything.index');
    }

    public function create()
    {
        return view('admin.anything.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'tagline' => 'nullable|string|max:255',
        ]);

        $anything = new Anything();

        $hasExistingTagline = Anything::query()->whereNotNull('tagline')->exists();
        if ($hasExistingTagline) {
            $validated['tagline'] = null;
        }

        $anything->title = $validated['title'];
        $anything->description = $validated['description'];
        $anything->tagline = $validated['tagline'] ?? null;

        $anything->save();

        return redirect()->route('admin.anything.index')
            ->with('success', 'Anything created successfully');
    }

    public function edit($id)
    {
        $anything = Anything::findOrFail($id);
        return view('admin.anything.edit', compact('anything'));
    }

    public function update(Request $request, $id)
    {
        $anything = Anything::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'tagline' => 'nullable|string|max:255',
        ]);

        $hasOtherTagline = Anything::query()
            ->where('id', '!=', $anything->id)
            ->whereNotNull('tagline')
            ->exists();

        if ($hasOtherTagline) {
            $validated['tagline'] = null;
        }

        $anything->title = $validated['title'];
        $anything->description = $validated['description'];
        $anything->tagline = $validated['tagline'] ?? null;

        $anything->save();

        return redirect()->route('admin.anything.index')
            ->with('success', 'Anything updated successfully');
    }

    public function destroy($id)
    {
        try {
            $anything = Anything::findOrFail($id);
            $anything->delete();

            return response()->json([
                'success' => true,
                'message' => 'Anything deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
