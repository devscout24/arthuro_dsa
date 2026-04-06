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
                ->addColumn('comming_soon', fn($banner) => e((string) ($banner->comming_soon ?? '')))
                ->addColumn('title', fn($banner) => e($banner->title))
                ->addColumn('tagline', fn($banner) => e((string) ($banner->tagline ?? '')))
                ->addColumn('button', fn($banner) => e((string) ($banner->button ?? '')))
                ->addColumn('career', fn($banner) => e((string) ($banner->career ?? '')))
                ->addColumn('description', fn($banner) => Str::limit(strip_tags($banner->description), 60))
                ->addColumn('image', function ($banner) {
                    $images = $banner->image ?? [];
                    if (!is_array($images)) {
                        $images = json_decode((string) $images, true) ?? [];
                    }
                    $images = array_values(array_filter(array_map('trim', $images), fn($v) => $v !== ''));

                    if (count($images) === 0) {
                        return 'N/A';
                    }

                    $first = $images[0];
                    $src = Str::startsWith($first, ['http://', 'https://', '//'])
                        ? $first
                        : asset('images/' . ltrim($first, '/'));

                    $countLabel = count($images) > 1 ? '<div class="small text-muted">+'.(count($images) - 1).' more</div>' : '';

                    return '<div><img src="' . e($src) . '" width="80" alt="image">' . $countLabel . '</div>';
                })
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

                        $html .= '<img src="' . e($src) . '" width="80" class="me-1" alt="icon">';
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
                ->rawColumns(['image', 'icons', 'action'])
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
        $validated = $request->validate([
            'comming_soon' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'button' => 'nullable|string|max:255',
            'career' => 'nullable|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'icons.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ]);

        $icons = [];

        if ($request->hasFile('icons')) {
            foreach ($request->file('icons') as $icon) {
                if (!$icon) {
                    continue;
                }

                $filename = time() . '_' . Str::random(8) . '.' . $icon->getClientOriginalExtension();
                $icon->move(public_path('images/icons'), $filename);
                $icons[] = 'icons/' . $filename;
            }
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if (!$image) {
                    continue;
                }

                $filename = time() . '_' . ($index + 1) . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/banners'), $filename);
                $imagePaths[] = 'banners/' . $filename;
            }
        }

        $features = $validated['features'] ?? [];
        if (!is_array($features)) {
            $features = [];
        }
        $features = array_values(array_filter(array_map('trim', $features), fn($v) => $v !== ''));

        Banner::create([
            'comming_soon' => $validated['comming_soon'] ?? null,
            'title' => $validated['title'],
            'tagline' => $validated['tagline'] ?? null,
            'button' => $validated['button'] ?? null,
            'career' => $validated['career'] ?? null,
            'description' => $validated['description'],
            'image' => $imagePaths,
            'icons' => $icons,
            'features' => $features,
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

        $validated = $request->validate([
            'comming_soon' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'button' => 'nullable|string|max:255',
            'career' => 'nullable|string|max:255',
            'description' => 'required|string',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|string|max:500',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'icons.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'existing_icons' => 'nullable|array',
            'existing_icons.*' => 'nullable|string|max:500',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ]);

        $icons = $request->existing_icons ?? [];
        if (!is_array($icons)) {
            $icons = [];
        }
        $icons = array_values(array_filter(array_map('trim', $icons), fn($v) => $v !== ''));

        if ($request->hasFile('icons')) {
            foreach ($request->file('icons') as $icon) {
                if (!$icon) {
                    continue;
                }

                $filename = time() . '_' . Str::random(8) . '.' . $icon->getClientOriginalExtension();
                $icon->move(public_path('images/icons'), $filename);
                $icons[] = 'icons/' . $filename;
            }
        }

        $existingImages = $request->existing_images ?? [];
        if (!is_array($existingImages)) {
            $existingImages = [];
        }
        $existingImages = array_values(array_filter(array_map('trim', $existingImages), fn($v) => $v !== ''));

        $currentImages = $banner->image ?? [];
        if (!is_array($currentImages)) {
            $currentImages = json_decode((string) $currentImages, true) ?? [];
        }
        $currentImages = array_values(array_filter(array_map('trim', $currentImages), fn($v) => $v !== ''));

        // Delete removed images from disk
        $removed = array_diff($currentImages, $existingImages);
        foreach ($removed as $path) {
            $path = trim((string) $path);
            if ($path === '' || Str::startsWith($path, ['http://', 'https://', '//'])) {
                continue;
            }

            $full = public_path('images/' . ltrim($path, '/'));
            if (file_exists($full)) {
                unlink($full);
            }
        }

        $imagePaths = $existingImages;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if (!$image) {
                    continue;
                }

                $filename = time() . '_' . ($index + 1) . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/banners'), $filename);
                $imagePaths[] = 'banners/' . $filename;
            }
        }

        $features = $validated['features'] ?? [];
        if (!is_array($features)) {
            $features = [];
        }
        $features = array_values(array_filter(array_map('trim', $features), fn($v) => $v !== ''));

        $banner->update([
            'comming_soon' => $validated['comming_soon'] ?? null,
            'title' => $validated['title'],
            'tagline' => $validated['tagline'] ?? null,
            'button' => $validated['button'] ?? null,
            'career' => $validated['career'] ?? null,
            'description' => $validated['description'],
            'image' => $imagePaths,
            'icons' => $icons,
            'features' => $features,
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'Banner updated successfully');
    }

    /**
     * Delete banner
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        $images = $banner->image ?? [];
        if (!is_array($images)) {
            $images = json_decode((string) $images, true) ?? [];
        }

        foreach ($images as $path) {
            $path = trim((string) $path);
            if ($path === '' || Str::startsWith($path, ['http://', 'https://', '//'])) {
                continue;
            }

            $full = public_path('images/' . ltrim($path, '/'));
            if (file_exists($full)) {
                unlink($full);
            }
        }

        $icons = $banner->icons ?? [];
        if (!is_array($icons)) {
            $icons = json_decode($icons, true) ?? [];
        }

        foreach ($icons as $icon) {
            $iconPath = trim((string) $icon);
            if ($iconPath === '' || Str::startsWith($iconPath, ['http://', 'https://', '//'])) {
                continue;
            }

            if (Str::startsWith($iconPath, 'icons/')) {
                $fullPath = public_path('images/' . $iconPath);
            } elseif (Str::startsWith($iconPath, 'images/icons/')) {
                $fullPath = public_path($iconPath);
            } else {
                $fullPath = public_path('images/icons/' . ltrim($iconPath, '/'));
            }

            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        $banner->delete();

        return response()->json([
            'success' => 'Banner deleted successfully'
        ]);
    }


}