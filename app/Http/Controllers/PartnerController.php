<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Partner::query()->latest();

            return datatables()->of($query)
                ->addIndexColumn()

                ->addColumn('title', function ($partner) {
                    return $partner->title;
                })

                ->addColumn('image', function ($partner) {
                    return '<img src="'.asset('images/'.$partner->image).'" width="80">';
                })

                ->addColumn('action', function ($partner) {

                    $editUrl = route('admin.partner.edit', $partner->id);

                    return '
                        <a href="'.$editUrl.'" class="btn btn-primary btn-sm me-1">
                            <i class="fa fa-edit"></i>
                        </a>

                        <button class="btn btn-danger btn-sm delete" data-id="'.$partner->id.'">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns(['image','action'])
                ->make(true);
        }

        return view('admin.partner.index');
    }


    public function create()
    {
        return view('admin.partner.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $hasExistingTitle = Partner::query()->whereNotNull('title')->exists();

        $titleForFirst = null;
        if (!$hasExistingTitle && !empty($validated['title'])) {
            $titleForFirst = $validated['title'];
        }

        $files = $request->file('images', []);
        foreach ($files as $index => $image) {
            $imageName = time().'_'.($index + 1).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            Partner::create([
                'title' => $index === 0 ? $titleForFirst : null,
                'image' => $imageName,
            ]);
        }

        return redirect()->route('admin.partner.index')
            ->with('success','Partner created successfully');
    }


    public function edit($id)
    {
        $partner = Partner::findOrFail($id);

        return view('admin.partner.edit', compact('partner'));
    }


    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $hasOtherTitle = Partner::query()
            ->where('id', '!=', $partner->id)
            ->whereNotNull('title')
            ->exists();

        if ($hasOtherTitle) {
            $validated['title'] = null;
        }

        $partner->title = $validated['title'] ?? null;

        if ($request->hasFile('image')) {

            if ($partner->image && file_exists(public_path('images/'.$partner->image))) {
                unlink(public_path('images/'.$partner->image));
            }

            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            $image->move(public_path('images'), $imageName);

            $partner->image = $imageName;
        }

        $partner->save();

        return redirect()->route('admin.partner.index')
            ->with('success','Partner updated successfully');
    }


    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);

        if ($partner->image && file_exists(public_path('images/'.$partner->image))) {
            unlink(public_path('images/'.$partner->image));
        }

        $partner->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Partner deleted successfully'
        ]);
    }
}