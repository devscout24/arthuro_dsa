<?php

namespace App\Http\Controllers;

use App\Models\Navbar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NavbarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $navbars = Navbar::latest();

            return datatables()->of($navbars)
                ->addIndexColumn()
                ->addColumn('logo', function ($navbar) {
                    $logo = (string) ($navbar->logo ?? '');
                    if ($logo === '') {
                        return 'N/A';
                    }

                    $src = Str::startsWith($logo, ['http://', 'https://', '//'])
                        ? $logo
                        : asset('images/' . ltrim($logo, '/'));

                    return '<img src="' . e($src) . '" width="80" alt="logo">';
                })
                ->addColumn('home', fn($navbar) => e((string) ($navbar->home ?? '')))
                ->addColumn('for', fn($navbar) => e((string) ($navbar->getAttribute('for') ?? '')))
                ->addColumn('story', fn($navbar) => e((string) ($navbar->story ?? '')))
                ->addColumn('waitlist', fn($navbar) => e((string) ($navbar->waitlist ?? '')))
                ->addColumn('action', function ($navbar) {
                    $editUrl = route('admin.navbar.edit', $navbar->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">
                            <i class="fa fa-edit"></i>
                        </a>

                        <button class="btn btn-danger btn-sm delete" data-id="' . $navbar->id . '">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['logo', 'action'])
                ->make(true);
        }

        return view('admin.navbar.index');
    }

    public function create()
    {
        return view('admin.navbar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif',
            'home' => 'nullable|string|max:255',
            'for' => 'nullable|string|max:255',
            'story' => 'nullable|string|max:255',
            'waitlist' => 'nullable|string|max:255',
        ]);

        $navbar = new Navbar();

        $navbar->home = $validated['home'] ?? null;
        $navbar->setAttribute('for', $validated['for'] ?? null);
        $navbar->story = $validated['story'] ?? null;
        $navbar->waitlist = $validated['waitlist'] ?? null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $navbar->logo = $filename;
        }

        $navbar->save();

        return redirect()->route('admin.navbar.index')
            ->with('success', 'Navbar created successfully');
    }

    public function edit($id)
    {
        $navbar = Navbar::findOrFail($id);
        return view('admin.navbar.edit', compact('navbar'));
    }

    public function update(Request $request, $id)
    {
        $navbar = Navbar::findOrFail($id);

        $validated = $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif',
            'home' => 'nullable|string|max:255',
            'for' => 'nullable|string|max:255',
            'story' => 'nullable|string|max:255',
            'waitlist' => 'nullable|string|max:255',
        ]);

        $navbar->home = $validated['home'] ?? null;
        $navbar->setAttribute('for', $validated['for'] ?? null);
        $navbar->story = $validated['story'] ?? null;
        $navbar->waitlist = $validated['waitlist'] ?? null;

        if ($request->hasFile('logo')) {
            if ($navbar->logo && file_exists(public_path('images/' . $navbar->logo))) {
                unlink(public_path('images/' . $navbar->logo));
            }

            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $navbar->logo = $filename;
        }

        $navbar->save();

        return redirect()->route('admin.navbar.index')
            ->with('success', 'Navbar updated successfully');
    }

    public function destroy($id)
    {
        $navbar = Navbar::findOrFail($id);

        if ($navbar->logo && file_exists(public_path('images/' . $navbar->logo))) {
            unlink(public_path('images/' . $navbar->logo));
        }

        $navbar->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Navbar deleted successfully'
        ]);
    }
}
