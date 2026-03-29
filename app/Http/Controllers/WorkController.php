<?php

namespace App\Http\Controllers;

use App\Models\work;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $works = work::all();

            return datatables()->of($works)
                ->addIndexColumn()
                ->addColumn('title', function ($work) {
                    return $work->title;
                })
                ->addColumn('description', function ($work) {
                    return Str::limit(strip_tags($work->description), 80);
                })
                ->addColumn('action', function ($work) {
                    $editUrl = route('admin.work.edit', $work->id);
                    return '
                    <a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-sm delete" data-id="' . $work->id . '">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.work.index');
    }

    public function create()
    {
        return view('admin.work.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $work = new work();
        $work->title = $request->title;
        $work->description = $request->description;
        $work->save();
        return redirect()->route('admin.work.index')->with('success', 'Work created successfully');
    }

    public function edit($id)
    {
        $work = work::findOrFail($id);
        return view('admin.work.edit', compact('work'));
    }

    public function update(Request $request, $id)
    {
        $work = work::findOrFail($id);

        $work->title = $request->title;
        $work->description = $request->description;
        $work->save();

        return redirect()->route('admin.work.index')->with('success', 'Work updated successfully');
    }

    public function destroy($id)
    {
        $work = Work::findOrFail($id);
        $work->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Work deleted successfully'
        ]);
    }
}
