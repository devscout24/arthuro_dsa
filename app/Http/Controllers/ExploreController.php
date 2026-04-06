<?php

namespace App\Http\Controllers;

use App\Models\Explore;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // Latest first
            $explores = Explore::latest()->get();

            return datatables()->of($explores)
                ->addIndexColumn() // This adds DT_RowIndex

                ->addColumn('title', function ($explore) {
                    return $explore->title;
                })

                ->addColumn('description', function ($explore) {
                    return Str::limit(strip_tags($explore->description), 80);
                })

                ->addColumn('image', function ($explore) {
                    return '<img src="' . asset('images/' . $explore->image) . '" width="80">';
                })

                ->addColumn('tagline', function ($explore) {
                    return $explore->tagline;
                })

                ->addColumn('action', function ($explore) {
                    $editUrl = route('admin.explore.edit', $explore->id);
                    return '
                    <a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-sm delete" data-id="' . $explore->id . '">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
                })

                ->rawColumns(['title', 'description', 'image', 'tagline', 'action'])
                ->make(true);
        }

        return view('admin.explore.index');
    }

    public function create()
    {
        return view('admin.explore.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'tagline' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png'
        ]);

        $explore = new Explore();

        $hasExistingTagline = Explore::query()->whereNotNull('tagline')->exists();
        if ($hasExistingTagline) {
            $validated['tagline'] = null;
        }

        $explore->title = $validated['title'];
        $explore->description = $validated['description'];
        $explore->tagline = $validated['tagline'] ?? null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $explore->image = $imageName;
        }

        $explore->save();

        return redirect()->route('admin.explore.index')
            ->with('success', 'Explore created successfully');
    }

    public function edit($id)
    {
        $explore = Explore::findOrFail($id);
        return view('admin.explore.edit', compact('explore'));
    }

    public function update(Request $request, $id)
    {
        $explore = Explore::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'tagline' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $hasOtherTagline = Explore::query()
            ->where('id', '!=', $explore->id)
            ->whereNotNull('tagline')
            ->exists();

        if ($hasOtherTagline) {
            $validated['tagline'] = null;
        }

        $explore->title = $validated['title'];
        $explore->description = $validated['description'];
        $explore->tagline = $validated['tagline'] ?? null;

        if ($request->hasFile('image')) {

            if ($explore->image && file_exists(public_path('images/' . $explore->image))) {
                unlink(public_path('images/' . $explore->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $explore->image = $imageName;
        }

        $explore->save();

        return redirect()->route('admin.explore.index')
            ->with('success', 'Explore updated successfully');
    }

    public function destroy($id)
    {
        $explore = Explore::findOrFail($id);

        if ($explore->image && file_exists(public_path('images/' . $explore->image))) {
            unlink(public_path('images/' . $explore->image));
        }

        $explore->delete();

        return response()->json([
            'success' => true,
            'message' => 'Explore deleted successfully'
        ]);
    }
}
