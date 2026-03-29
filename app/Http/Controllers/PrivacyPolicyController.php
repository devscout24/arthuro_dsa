<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PrivacyPolicyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = PrivacyPolicy::latest();

            return datatables()->of($items)
                ->addIndexColumn()
                ->addColumn('description', function ($item) {
                    return Str::limit(strip_tags($item->description), 80);
                })
                ->addColumn('action', function ($item) {
                    $editUrl = route('admin.privacy-policy.edit', $item->id);
                    return '<a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1"><i class="fa fa-edit"></i></a>' .
                        '<button class="btn btn-danger btn-sm delete" data-id="' . $item->id . '"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.privacy_policy.index');
    }

    public function create()
    {
        return view('admin.privacy_policy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        PrivacyPolicy::create($request->only('title', 'description'));

        return redirect()->route('admin.privacy-policy.index')->with('success', 'Privacy policy created successfully');
    }

    public function edit($id)
    {
        $policy = PrivacyPolicy::findOrFail($id);
        return view('admin.privacy_policy.edit', compact('policy'));
    }

    public function update(Request $request, $id)
    {
        $policy = PrivacyPolicy::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $policy->update($request->only('title', 'description'));

        return redirect()->route('admin.privacy-policy.index')->with('success', 'Privacy policy updated successfully');
    }

    public function destroy($id)
    {
        try {
            $policy = PrivacyPolicy::findOrFail($id);
            $policy->delete();

            return response()->json(['success' => true, 'message' => 'Privacy policy deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
