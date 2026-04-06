<?php

namespace App\Http\Controllers;

use App\Models\Negotiable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NegotiableController extends Controller
{
    private function linesToArray(?string $value): ?array
    {
        if ($value === null) {
            return null;
        }

        $lines = preg_split('/\r\n|\r|\n/', $value);
        if (!$lines) {
            return null;
        }

        $items = array_values(array_filter(array_map(static fn($line) => trim((string) $line), $lines), static fn($line) => $line !== ''));

        return $items === [] ? null : $items;
    }

    private function normalizeToArray($value): ?array
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            $items = array_values(array_filter(array_map(static fn($item) => trim((string) $item), $value), static fn($item) => $item !== ''));
            return $items === [] ? null : $items;
        }

        return $this->linesToArray((string) $value);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Negotiable::latest();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('title', fn($row) => e($row->title))
                ->addColumn('tagline', function ($row) {
                    $items = is_array($row->tagline) ? $row->tagline : [];
                    return e(implode(', ', array_filter(array_map('strval', $items))));
                })
                ->addColumn('description', fn($row) => Str::limit(strip_tags((string) $row->description), 100))
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.negotiable.edit', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.negotiable.index');
    }

    public function create()
    {
        return view('admin.negotiable.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tagline' => 'nullable',
            'tagline.*' => 'nullable|string',
        ]);

        $validated['tagline'] = $this->normalizeToArray($request->input('tagline'));

        Negotiable::create($validated);

        return redirect()->route('admin.negotiable.index')
            ->with('success', 'Negotiable created successfully');
    }

    public function edit($id)
    {
        $negotiable = Negotiable::findOrFail($id);

        return view('admin.negotiable.edit', compact('negotiable'));
    }

    public function update(Request $request, $id)
    {
        $negotiable = Negotiable::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tagline' => 'nullable',
            'tagline.*' => 'nullable|string',
        ]);

        $validated['tagline'] = $this->normalizeToArray($request->input('tagline'));

        $negotiable->update($validated);

        return redirect()->route('admin.negotiable.index')
            ->with('success', 'Negotiable updated successfully');
    }

    public function destroy($id)
    {
        $negotiable = Negotiable::findOrFail($id);
        $negotiable->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Negotiable deleted successfully'
        ]);
    }
}
