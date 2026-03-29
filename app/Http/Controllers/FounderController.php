<?php

namespace App\Http\Controllers;

use App\Models\Founder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FounderController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $founders = Founder::latest();

            return datatables()->of($founders)
                ->addIndexColumn()

                ->addColumn('title', function ($row) {
                    return $row->title;
                })

                ->addColumn('designation', function ($row) {
                    return Str::limit(strip_tags($row->designation), 80);
                })

                ->addColumn('description', function ($row) {
                    return Str::limit(strip_tags($row->description), 80);
                })

                ->addColumn('image', function ($row) {

                    if ($row->image) {
                        return '<img src="' . asset('founders/'.$row->image) . '" width="50">';
                    }

                    return 'N/A';
                })

                ->addColumn('action', function ($row) {

                    $editUrl = route('admin.founder.edit', $row->id);

                    return '
                        <a href="'.$editUrl.'" class="btn btn-primary btn-sm me-1">
                            <i class="fa fa-edit"></i>
                        </a>

                        <button class="btn btn-danger btn-sm delete" data-id="'.$row->id.'">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns(['image','action'])
                ->make(true);
        }

        return view('admin.founder.index');
    }


    public function create()
    {
        return view('admin.founder.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'designation' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $founder = new Founder();

        $founder->title = $request->title;
        $founder->designation = $request->designation;
        $founder->description = $request->description;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('founders'), $filename);

            $founder->image = $filename;
        }

        $founder->save();

        return redirect()->route('admin.founder.index')
            ->with('success','Founder created successfully');
    }


    public function edit($id)
    {
        $founder = Founder::findOrFail($id);
        return view('admin.founder.edit', compact('founder'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'designation' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $founder = Founder::findOrFail($id);

        $founder->title = $request->title;
        $founder->designation = $request->designation;
        $founder->description = $request->description;

        if ($request->hasFile('image')) {

            if ($founder->image && file_exists(public_path('founders/'.$founder->image))) {
                unlink(public_path('founders/'.$founder->image));
            }

            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('founders'), $filename);

            $founder->image = $filename;
        }

        $founder->save();

        return redirect()->route('admin.founder.index')
            ->with('success','Founder updated successfully');
    }


    public function destroy($id)
    {
        $founder = Founder::findOrFail($id);

        if ($founder->image && file_exists(public_path('founders/'.$founder->image))) {
            unlink(public_path('founders/'.$founder->image));
        }

        $founder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Founder deleted successfully'
        ]);
    }

}