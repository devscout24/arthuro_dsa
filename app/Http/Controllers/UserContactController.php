<?php

namespace App\Http\Controllers;

use App\Models\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserContactController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $contacts = UserContact::latest()->get();
            return datatables()->of($contacts)
                ->addIndexColumn()
                ->addColumn('message', function ($contact) {
                    return Str::limit(strip_tags($contact->message), 80);
                })
                ->addColumn('action', function ($contact) {
                    
                    return '
                   
                    <button class="btn btn-danger btn-sm delete" data-id="' . $contact->id . '">
                        <i class="fa fa-trash"></i>
                    </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.usercontact.index');
    }






    public function destroy($id)
    {
        try {
            $contact = UserContact::findOrFail($id);
            $contact->delete();

            return response()->json([
                'success' => true,
                'message' => 'User contact deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
