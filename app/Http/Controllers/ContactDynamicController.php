<?php

namespace App\Http\Controllers;

use App\Models\ContactDynamic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactDynamicController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = ContactDynamic::latest();

            return datatables()->of($items)
                ->addIndexColumn()
                ->editColumn('title', function ($item) {
                    return e(Str::limit((string) $item->title, 60));
                })
                ->editColumn('button', function ($item) {
                    return e(Str::limit((string) $item->button, 60));
                })
                ->editColumn('description', function ($item) {
                    return e(Str::limit(strip_tags((string) $item->description), 80));
                })
                ->addColumn('action', function ($item) {
                    $editUrl = route('admin.contact-dynamic.edit', $item->id);
                    return '<a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1"><i class="fa fa-edit"></i></a>' .
                        '<button class="btn btn-danger btn-sm delete" data-id="' . $item->id . '"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.contact_dynamic.index');
    }

    public function create()
    {
        return view('admin.contact_dynamic.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        ContactDynamic::create($data);

        return redirect()->route('admin.contact-dynamic.index')->with('success', 'Contact section created successfully');
    }

    public function edit($id)
    {
        $contactDynamic = ContactDynamic::findOrFail($id);
        return view('admin.contact_dynamic.edit', compact('contactDynamic'));
    }

    public function update(Request $request, $id)
    {
        $contactDynamic = ContactDynamic::findOrFail($id);
        $data = $this->validatedData($request);
        $contactDynamic->update($data);

        return redirect()->route('admin.contact-dynamic.index')->with('success', 'Contact section updated successfully');
    }

    public function destroy($id)
    {
        try {
            $contactDynamic = ContactDynamic::findOrFail($id);
            $contactDynamic->delete();

            return response()->json(['success' => true, 'message' => 'Contact section deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'name_label' => 'nullable|string|max:255',
            'name_placeholder' => 'nullable|string|max:255',
            'email_label' => 'nullable|string|max:255',
            'email_placeholder' => 'nullable|string|max:255',
            'phone_label' => 'nullable|string|max:255',
            'phone_placeholder' => 'nullable|string|max:255',
            'message_label' => 'nullable|string|max:255',
            'message_placeholder' => 'nullable|string|max:255',
            'button' => 'nullable|string|max:255',
        ]);
    }
}
