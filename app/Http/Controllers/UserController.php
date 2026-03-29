<?php

namespace App\Http\Controllers;

use App\Models\GeneralUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = GeneralUser::latest()->get();

            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($user) {

                    $deleteUrl = route('admin.user.destroy', $user->id);

                    return '
                            <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm delete-button">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.user.index');
    }

    // public function create()
    // {
    //     return view('admin.user.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255|unique:users,email'
    //     ]);

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email
    //     ]);

    //     return redirect()->route('admin.user.index')->with('success', 'User created successfully');
    // }


    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            if (auth()->check() && auth()->id() === $user->id) {
                return response()->json(['success' => false, 'message' => 'You cannot delete your own account.'], 403);
            }

            $user->delete();

            return response()->json(['success' => true, 'message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
