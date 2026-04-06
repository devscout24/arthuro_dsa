<?php

namespace App\Http\Controllers;

use App\Models\Cookie as CookieModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CookieController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cookies = CookieModel::latest();

            return datatables()->of($cookies)
                ->addIndexColumn()
                ->addColumn('description', function ($cookie) {
                    return Str::limit(strip_tags((string) ($cookie->description ?? '')), 80);
                })
                ->addColumn('reject', fn($cookie) => e((string) ($cookie->reject ?? '')))
                ->addColumn('accept', fn($cookie) => e((string) ($cookie->accept ?? '')))
                ->addColumn('action', function ($cookie) {
                    $editUrl = route('admin.cookie.edit', $cookie->id);
                    return '<a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1"><i class="fa fa-edit"></i></a>' .
                        '<button class="btn btn-danger btn-sm delete" data-id="' . $cookie->id . '"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.cookie.index');
    }

    public function create()
    {
        return view('admin.cookie.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'reject' => 'nullable|string|max:255',
            'accept' => 'nullable|string|max:255',
        ]);

        CookieModel::create($validated);

        return redirect()->route('admin.cookie.index')->with('success', 'Cookie created successfully');
    }

    public function edit($id)
    {
        $cookie = CookieModel::findOrFail($id);
        return view('admin.cookie.edit', compact('cookie'));
    }

    public function update(Request $request, $id)
    {
        $cookie = CookieModel::findOrFail($id);

        $validated = $request->validate([
            'description' => 'nullable|string',
            'reject' => 'nullable|string|max:255',
            'accept' => 'nullable|string|max:255',
        ]);

        $cookie->update($validated);

        return redirect()->route('admin.cookie.index')->with('success', 'Cookie updated successfully');
    }

    public function destroy($id)
    {
        try {
            $cookie = CookieModel::findOrFail($id);
            $cookie->delete();

            return response()->json(['success' => true, 'message' => 'Cookie deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
