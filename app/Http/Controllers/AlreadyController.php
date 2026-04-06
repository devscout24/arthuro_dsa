<?php

namespace App\Http\Controllers;

use App\Models\Already;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlreadyController extends Controller
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
            $data = Already::latest();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('title', fn($row) => e($row->title))
                ->addColumn('tag_head', function ($row) {
                    $items = is_array($row->tag_head) ? $row->tag_head : [];
                    return e(implode(', ', array_filter(array_map('strval', $items))));
                })
                ->addColumn('tag_body', function ($row) {
                    $items = is_array($row->tag_body) ? $row->tag_body : [];
                    return e(implode(', ', array_filter(array_map('strval', $items))));
                })
                ->addColumn('tag_number', function ($row) {
                    $items = is_array($row->tag_number) ? $row->tag_number : [];
                    return e(implode(', ', array_filter(array_map('strval', $items))));
                })
                ->addColumn('description', fn($row) => Str::limit(strip_tags((string) $row->description), 100))
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.already.edit', $row->id);

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

        return view('admin.already.index');
    }

    public function create()
    {
        return view('admin.already.create');
    }

    public function edit($id)
    {
        $already = Already::findOrFail($id);

        return view('admin.already.edit', compact('already'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        Already::create($data);

        return redirect()->route('admin.already.index')->with('success', 'Already created successfully');
    }

    public function update(Request $request, $id)
    {
        $already = Already::findOrFail($id);
        $data = $this->validatedData($request);

        $already->update($data);

        return redirect()->route('admin.already.index')->with('success', 'Already updated successfully');
    }

    public function destroy($id)
    {
        $already = Already::findOrFail($id);
        $already->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Already deleted successfully'
        ]);
    }

    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'tag_head' => 'nullable',
            'tag_body' => 'nullable',
            'tag_number' => 'nullable',
            'tag_head.*' => 'nullable|string',
            'tag_body.*' => 'nullable|string',
            'tag_number.*' => 'nullable|string',
        ]);

        // Support both textarea (string) and array inputs; always store as JSON arrays.
        $validated['tag_head'] = $this->normalizeToArray($request->input('tag_head'));
        $validated['tag_body'] = $this->normalizeToArray($request->input('tag_body'));
        $validated['tag_number'] = $this->normalizeToArray($request->input('tag_number'));

        return $validated;
    }
}
