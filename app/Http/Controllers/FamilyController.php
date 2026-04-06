<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FamilyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Family::query()->latest();
            return datatables()->of($query)
                ->addIndexColumn()
                ->orderColumn('DT_RowIndex', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('title', function ($family) {
                    return $family->title;
                })
                ->addColumn('button', function ($family) {
                    return $family->button;
                })
                ->addColumn('description', function ($family) {
                    return Str::limit(strip_tags($family->description), 80);
                })
                ->addColumn('image', function ($family) {
                    if (!$family->image) {
                        return 'N/A';
                    }
                    return '<img src="' . asset('images/' . $family->image) . '" alt="' . $family->title . '" width="80">';
                })
                ->addColumn('action', function ($family) {
                    $editUrl = route('admin.family.edit', $family->id);
                    return '
                    <a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-sm delete" data-id="' . $family->id . '">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
                })
                ->rawColumns(['title', 'description', 'image', 'action'])
                ->make(true);
        }
        return view('admin.family.index');
    }


    public function create()
    {
        return view('admin.family.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'button' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        // Handle the form submission
        $family = new Family();

        $family->title = $validated['title'];
        $family->button = $validated['button'] ?? null;
        $family->description = $validated['description'];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $family->image = $imageName;
        }
        $family->save();

        return redirect()->route('admin.family.index');
    }

    public function edit($id)
    {
        $family = Family::findOrFail($id);
        return view('admin.family.edit', compact('family'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'button' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $family = Family::findOrFail($id);

        $family->title = $validated['title'];
        $family->button = $validated['button'] ?? null;
        $family->description = $validated['description'];

        // image update
        if ($request->hasFile('image')) {

            // delete old image
            if ($family->image && file_exists(public_path('images/' . $family->image))) {
                unlink(public_path('images/' . $family->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $family->image = $imageName;
        }

        $family->save();

        return redirect()->route('admin.family.index')
            ->with('success', 'Family updated successfully');
    }

    public function destroy($id)
    {
        $family = Family::findOrFail($id);

        // delete image file if exists
        if ($family->image && file_exists(public_path('images/' . $family->image))) {
            unlink(public_path('images/' . $family->image));
        }

        $family->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Family deleted successfully'
        ]);
    }
}
