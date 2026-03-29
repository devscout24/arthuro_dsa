<?php

namespace App\Http\Controllers;

use App\Models\Misson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MissonController extends Controller
{
    // Mission Index with AJAX for DataTables
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Misson::latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('title', function($row){
                    return $row->title;
                })
                ->addColumn('description', function($row){
                    return Str::limit(strip_tags($row->description), 80);
                })
                ->addColumn('action', function($row){
                    $editUrl = route('admin.misson.edit', $row->id);
                    $btn = '<a href="'.$editUrl.'" class="btn btn-primary btn-sm me-1">
                                <i class="fa fa-edit"></i>
                            </a>';
                    $btn .= ' <button class="btn btn-danger btn-sm delete" data-id="'.$row->id.'">
                                <i class="fa fa-trash"></i>
                            </button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.misson.index');
    }

    // Show create form
    public function create()
    {
        return view('admin.misson.create');
    }

    // Store new mission
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $misson = new Misson();
        $misson->title = $request->title;
        $misson->description = $request->description;
        $misson->save();

        return redirect()->route('admin.misson.index')
            ->with('success', 'Mission created successfully');
    }

    // Show edit form
public function edit($id)
{
    $mission = Misson::findOrFail($id); // use $mission here, not $misson
    return view('admin.misson.edit', compact('mission'));
}
    // Update mission
public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
    ]);

    $mission = Misson::findOrFail($id);
    $mission->title = $request->title;
    $mission->description = $request->description;
    $mission->save();

    return redirect()->route('admin.misson.index')
        ->with('success', 'Mission updated successfully');
}
    // Delete mission via AJAX
    public function destroy($id)
    {
        $misson = Misson::findOrFail($id);
        $misson->delete();

        // Return JSON for AJAX delete
        return response()->json([
            'success' => true,
            'message' => 'Mission deleted successfully'
        ]);
    }
}