<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $teams = Team::latest();

            return datatables()->of($teams)
                ->addIndexColumn()

                ->addColumn('title', function ($row) {
                    return $row->title;
                })

                ->addColumn('designation', function ($row) {
                    return Str::limit(strip_tags($row->designation), 80);
                })

                ->addColumn('image', function ($row) {

                    if ($row->image) {
                        return '<img src="'.asset('teams/'.$row->image).'" width="50">';
                    }

                    return 'N/A';
                })

                ->addColumn('action', function ($row) {

                    $editUrl = route('admin.team.edit',$row->id);

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

        return view('admin.team.index');
    }


    public function create()
    {
        return view('admin.team.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'designation' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $team = new Team();

        $team->title = $request->title;
        $team->designation = $request->designation;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('teams'), $filename);

            $team->image = $filename;
        }

        $team->save();

        return redirect()->route('admin.team.index')
            ->with('success','Team created successfully');
    }


    public function edit($id)
    {
        $team = Team::findOrFail($id);
        return view('admin.team.edit',compact('team'));
    }


    public function update(Request $request,$id)
    {
        $request->validate([
            'title' => 'required',
            'designation' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $team = Team::findOrFail($id);

        $team->title = $request->title;
        $team->designation = $request->designation;

        if ($request->hasFile('image')) {

            if ($team->image && file_exists(public_path('teams/'.$team->image))) {
                unlink(public_path('teams/'.$team->image));
            }

            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('teams'), $filename);

            $team->image = $filename;
        }

        $team->save();

        return redirect()->route('admin.team.index')
            ->with('success','Team updated successfully');
    }


    public function destroy($id)
    {
        $team = Team::findOrFail($id);

        if ($team->image && file_exists(public_path('teams/'.$team->image))) {
            unlink(public_path('teams/'.$team->image));
        }

        $team->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Team deleted successfully'
        ]);
    }
}