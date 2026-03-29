<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display the DataTables listing of banners
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $banners = Banner::latest(); // Eloquent query

            return DataTables::eloquent($banners)
                ->addIndexColumn()
                ->addColumn('title', fn($banner) => e($banner->title))
                ->addColumn('description', fn($banner) => Str::limit(strip_tags($banner->description), 60))
                ->addColumn('icons', function ($banner) {
                    $icons = $banner->icons ?? [];
                    if (!is_array($icons)) {
                        $icons = json_decode($icons, true) ?? [];
                    }
                    $html = '';
                    foreach ($icons as $icon) {
                        $iconPath = trim((string) $icon);

                        if ($iconPath === '') {
                            continue;
                        }

                        if (Str::startsWith($iconPath, ['http://', 'https://', '//'])) {
                            $src = $iconPath;
                        } elseif (Str::startsWith($iconPath, ['storage/', 'images/'])) {
                            $src = asset($iconPath);
                        } elseif (Str::startsWith($iconPath, 'icons/')) {
                            $src = asset('images/' . $iconPath);
                        } else {
                            $src = asset('images/icons/' . $iconPath);
                        }

                        $html .= '<img src="' . e($src) . '" width="30" class="me-1" alt="icon">';
                    }
                    return $html;
                })
                ->addColumn('features', function ($banner) {
                    $features = $banner->features ?? [];
                    if (!is_array($features)) {
                        $features = json_decode($features, true) ?? [];
                    }
                    return implode(', ', $features);
                })
                ->addColumn('action', function ($banner) {
                    return '
                        <a href="' . route('admin.banner.edit', $banner->id) . '" class="btn btn-sm btn-success">Edit</a>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $banner->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['icons', 'action'])
                ->make(true);
        }

        return view('admin.banner.index');
    }

    /**
     * Show create banner form
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store new banner
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $icons = [];

        if ($request->hasFile('icons')) {
            foreach ($request->file('icons') as $icon) {
                $filename = time() . '_' . $icon->getClientOriginalName();
                $icon->move(public_path('images/icons'), $filename);
                $icons[] = 'icons/' . $filename;
            }
        }

        Banner::create([
            'title' => $request->title,
            'description' => $request->description,
            'icons' => $icons,
            'features' => $request->features ?? [],
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'Banner created successfully');
    }

    /**
     * Show edit banner form
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * Update existing banner
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $icons = $request->existing_icons ?? [];

        if ($request->hasFile('icons')) {
            foreach ($request->file('icons') as $icon) {
                $filename = time() . '_' . $icon->getClientOriginalName();
                $icon->move(public_path('images/icons'), $filename);
                $icons[] = 'icons/' . $filename;
            }
        }

        $banner->update([
            'title' => $request->title,
            'description' => $request->description,
            'icons' => $icons,
            'features' => $request->features ?? [],
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'Banner updated successfully');
    }

    /**
     * Delete banner
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return response()->json([
            'success' => 'Banner deleted successfully'
        ]);
    }


}