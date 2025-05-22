<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:admin');
    // }
    public function index()
    {
        return view('admin.user.index');
    }

    public function create(Request $request)
    {
        return view('admin.user.form', [
            'user' => new User(),
        ]);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $validate['password'] = bcrypt($validate['password']);
            $user = User::create($validate);
            $user->assignRole($validate['role']);
            DB::commit();
            return redirect()->route('user.index')->with('success', 'User Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('user.index')->with('error', 'User Gagal Ditambahkan');
        }
    }

    public function edit(User $user)
    {
        return view('admin.user.form', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'role' => 'nullable',
        ]);
        DB::beginTransaction();
        try {
            if ($request->filled('password')) {
                $validate['password'] = bcrypt($validate['password']);
            } else {
                unset($validate['password']);
            }
            $user->update($validate);
            $user->syncRoles($validate['role']);
            DB::commit();
            return redirect()->route('user.index')->with('success', 'User Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('user.index')->with('error', 'User Gagal Diupdate');
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            if ($user->id == 1) {
                return redirect()->route('user.index')->with('error', 'Tidak Dapat Menghapus User Administrator');
            }
            $user->delete();
            DB::commit();
            return redirect()->route('user.index')->with('success', 'User Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('user.index')->with('error', 'User Gagal Diupdate');
        }
    }
    public function datatable()
    {
        $query =  User::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('role', function ($data) {
                return ucfirst($data->getRoleNames()[0]);
            })
            ->addColumn('action', function ($data) {
                return view('components.datatable.action', [
                    'urlEdit'   => route('user.edit', $data->id),
                    'urlDelete' => route('user.destroy', $data->id),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
