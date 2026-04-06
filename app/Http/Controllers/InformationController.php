<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InformationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = Information::latest();

            return datatables()->of($items)
                ->addIndexColumn()
                ->addColumn('email_icon', function ($item) {
                    return $item->email_icon;
                })
                ->addColumn('description', function ($item) {
                    return Str::limit(strip_tags((string) $item->description), 80);
                })
                ->addColumn('linkedin_icon', function ($item) {
                    return $item->linkedin_icon;
                })
                ->addColumn('instagram_icon', function ($item) {
                    return $item->instagram_icon;
                })
                ->addColumn('action', function ($item) {
                    $editUrl = route('admin.information.edit', $item->id);
                    return '<a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1"><i class="fa fa-edit"></i></a>' .
                        '<button class="btn btn-danger btn-sm delete" data-id="' . $item->id . '"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.information.index');
    }

    public function create()
    {
        return view('admin.information.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        Information::create($data);

        return redirect()->route('admin.information.index')->with('success', 'Information created successfully');
    }

    public function edit($id)
    {
        $information = Information::findOrFail($id);

        return view('admin.information.edit', compact('information'));
    }

    public function update(Request $request, $id)
    {
        $information = Information::findOrFail($id);
        $data = $this->validatedData($request);

        $information->update($data);

        return redirect()->route('admin.information.index')->with('success', 'Information updated successfully');
    }

    public function destroy($id)
    {
        try {
            $information = Information::findOrFail($id);
            $information->delete();

            return response()->json(['success' => true, 'message' => 'Information deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'email_label' => 'nullable|string|max:255',
            'email_icon' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'tagline' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'linkedin_icon' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'instagram_icon' => 'nullable|string|max:255',
        ]);
    }
}
