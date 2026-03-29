<?php

namespace App\Http\Controllers;

use App\Models\Carrer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarrerController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Carrer::latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('numbers', function($row){
                    return $row->numbers;
                })
                ->addColumn('tagline', function($row){
                    return $row->tagline;
                })
                ->addColumn('title', function($row){
                    return $row->title;
                })
                // 80 characters and strip tags
                ->addColumn('description', function($row){
                    return Str::limit(strip_tags($row->description), 80);
                })
                ->addColumn('action', function($row){
                    $editUrl = route('admin.carrer.edit', $row->id);
                    $actionBtn = '<a href="'.$editUrl.'" class="btn btn-primary btn-sm me-1"><i class="fa fa-edit"></i></a>';
                    $deleteUrl = route('admin.carrer.destroy', $row->id);
                    $actionBtn .= '<form action="'.$deleteUrl.'" method="POST" style="display:inline-block;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm delete-button">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>';
                    return $actionBtn;
                })
                ->rawColumns(['numbers','tagline','title','description','action'])
                ->make(true);
        }
        return view('admin.carrer.index');
    }


    public function create()
    {
        return view('admin.carrer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numbers' => 'required',
            'tagline' => 'required',
            'title' => 'required',
            'description' => 'required',


        ]);

        // Handle the form submission
        $carrer = new Carrer();
        $carrer->numbers = $request->numbers;
        $carrer->tagline = $request->tagline;
        $carrer->title = $request->title;
        $carrer->description = $request->description;
        $carrer->save();

        return redirect()->route('admin.carrer.index');
    }

    public function edit($id)
    {
        $carrer = Carrer::findOrFail($id);
        return view('admin.carrer.edit', compact('carrer'));
    }

    public function update(Request $request, $id)
    {
        $carrer = Carrer::findOrFail($id);
        $carrer->numbers = $request->numbers;
        $carrer->tagline = $request->tagline;
        $carrer->title = $request->title;
        $carrer->description = $request->description;
        $carrer->save();

        return redirect()->route('admin.carrer.index');
    }

    public function destroy($id)
    {
        $carrer = Carrer::findOrFail($id);
        $carrer->delete();
        return redirect()->route('admin.carrer.index');
    }
}
