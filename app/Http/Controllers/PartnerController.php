<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $partners = Partner::all();

            return datatables()->of($partners)
                ->addIndexColumn()


                ->addColumn('image', function ($partner) {
                    return '<img src="'.asset('images/'.$partner->image).'" width="80">';
                })

                ->addColumn('action', function ($partner) {

                    $editUrl = route('admin.partner.edit', $partner->id);

                    return '
                        <a href="'.$editUrl.'" class="btn btn-primary btn-sm me-1">
                            <i class="fa fa-edit"></i>
                        </a>

                        <button class="btn btn-danger btn-sm delete" data-id="'.$partner->id.'">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns(['image','action'])
                ->make(true);
        }

        return view('admin.partner.index');
    }


    public function create()
    {
        return view('admin.partner.create');
    }


    public function store(Request $request)
    {
        $request->validate([

            'image' => 'required|image|mimes:jpg,jpeg,png'
        ]);

        $partner = new Partner();


        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            $image->move(public_path('images'), $imageName);

            $partner->image = $imageName;
        }

        $partner->save();

        return redirect()->route('admin.partner.index')
            ->with('success','Partner created successfully');
    }


    public function edit($id)
    {
        $partner = Partner::findOrFail($id);

        return view('admin.partner.edit', compact('partner'));
    }


    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);


        if ($request->hasFile('image')) {

            if ($partner->image && file_exists(public_path('images/'.$partner->image))) {
                unlink(public_path('images/'.$partner->image));
            }

            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            $image->move(public_path('images'), $imageName);

            $partner->image = $imageName;
        }

        $partner->save();

        return redirect()->route('admin.partner.index')
            ->with('success','Partner updated successfully');
    }


    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);

        if ($partner->image && file_exists(public_path('images/'.$partner->image))) {
            unlink(public_path('images/'.$partner->image));
        }

        $partner->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Partner deleted successfully'
        ]);
    }
}