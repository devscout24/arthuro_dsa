<?php

namespace App\Http\Controllers;

use App\Models\FooterDown;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FooterDownController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = FooterDown::latest();

            return datatables()->of($items)
                ->addIndexColumn()
                ->addColumn('privacy', fn($row) => e((string) ($row->privacy ?? '')))
                ->addColumn('terms', fn($row) => e((string) ($row->terms ?? '')))
                ->addColumn('contact', fn($row) => e((string) ($row->contact ?? '')))
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.footer-down.edit', $row->id);
                    return '<a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1"><i class="fa fa-edit"></i></a>' .
                        '<button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.footer_down.index');
    }

    public function create()
    {
        return view('admin.footer_down.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'privacy' => 'nullable|string|max:255',
            'terms' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
        ]);

        FooterDown::create($validated);

        return redirect()->route('admin.footer-down.index')->with('success', 'Footer item created successfully');
    }

    public function edit($id)
    {
        $footerDown = FooterDown::findOrFail($id);
        return view('admin.footer_down.edit', compact('footerDown'));
    }

    public function update(Request $request, $id)
    {
        $footerDown = FooterDown::findOrFail($id);

        $validated = $request->validate([
            'privacy' => 'nullable|string|max:255',
            'terms' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
        ]);

        $footerDown->update($validated);

        return redirect()->route('admin.footer-down.index')->with('success', 'Footer item updated successfully');
    }

    public function destroy($id)
    {
        try {
            $footerDown = FooterDown::findOrFail($id);
            $footerDown->delete();

            return response()->json(['success' => true, 'message' => 'Footer item deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
