<?php

namespace App\Http\Controllers;

use App\Models\Horizon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HorizonController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $horizon = Horizon::latest()->get();

            return datatables()->of($horizon)
                ->addIndexColumn()

                ->addColumn('title', function ($horizon) {
                    return $horizon->title;
                })

                ->addColumn('description', function ($horizon) {
                    return Str::limit(strip_tags($horizon->description), 80);
                })

                ->addColumn('image', function ($horizon) {
                    return '<img src="' . asset('images/' . $horizon->image) . '" width="80">';
                })

                ->addColumn('tagline', function ($horizon) {
                    return $horizon->tagline;
                })

                ->addColumn('action', function ($horizon) {

                    $editUrl = route('admin.horizon.edit', $horizon->id);

                    return '
                    <a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">
                        <i class="fa fa-edit"></i>
                    </a>

                    <button class="btn btn-danger btn-sm delete" data-id="' . $horizon->id . '">
                        <i class="fa fa-trash"></i>
                    </button>
                    ';
                })

                ->rawColumns(['title', 'description', 'image', 'tagline', 'action'])
                ->make(true);
        }

        return view('admin.horizon.index');
    }


    public function create()
    {
        return view('admin.horizon.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'tagline' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png'
        ]);

        $horizon = new Horizon();

        $hasExistingTagline = Horizon::query()->whereNotNull('tagline')->exists();
        if ($hasExistingTagline) {
            $validated['tagline'] = null;
        }

        $horizon->title = $validated['title'];
        $horizon->description = $validated['description'];
        $horizon->tagline = $validated['tagline'] ?? null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $horizon->image = $imageName;
        }

        $horizon->save();

        return redirect()->route('admin.horizon.index')
            ->with('success', 'Horizon created successfully');
    }


    public function edit($id)
    {
        $horizon = Horizon::findOrFail($id);

        return view('admin.horizon.edit', compact('horizon'));
    }


    public function update(Request $request, $id)
    {
        $horizon = Horizon::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'tagline' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $hasOtherTagline = Horizon::query()
            ->where('id', '!=', $horizon->id)
            ->whereNotNull('tagline')
            ->exists();

        if ($hasOtherTagline) {
            $validated['tagline'] = null;
        }

        $horizon->title = $validated['title'];
        $horizon->description = $validated['description'];
        $horizon->tagline = $validated['tagline'] ?? null;

        if ($request->hasFile('image')) {

            if ($horizon->image && file_exists(public_path('images/' . $horizon->image))) {
                unlink(public_path('images/' . $horizon->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $horizon->image = $imageName;
        }

        $horizon->save();

        return redirect()->route('admin.horizon.index')
            ->with('success', 'Horizon updated successfully');
    }

    public function destroy($id)
    {
        $horizon = Horizon::findOrFail($id);

        if ($horizon->image && file_exists(public_path('images/' . $horizon->image))) {
            unlink(public_path('images/' . $horizon->image));
        }

        $horizon->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
