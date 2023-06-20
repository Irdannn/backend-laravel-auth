<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;


class UserProfileController extends Controller
{
    public function index()
    {
        $userProfile = UserProfile::all()->toArray();
       return $userProfile;
    }

    public function store(Request $request)
    {
        $userProfile = UserProfile::create([
            'id_user' => $request->id_user,
            'name' => $request->name,
            'alamat' => $request->alamat,
            'tempatLahir' => $request->tempatLahir,
            'tanggalLahir' => $request->tanggalLahir,
            'pendidikanTerakhir' => $request->pendidikanTerakhir,
            'pekerjaan' => $request->pekerjaan,
            'penghasilan' => $request->penghasilan,
            'noHp' => $request->noHp,
            'role' => $request->role,
            'email' => $request->email,
            'bio' => $request->bio
        ]);

        if ($request->has('id_user')) {
            $user = User::find($request->input('id_user'));
            $user->update(['name' => $request->input('name')]);
            $user->update(['role' => $request->input('role')]);
            $user->update(['email' => $request->input('email')]);
        }
        return $userProfile;
    }
    public function show($id)
    {
        return UserProfile::find($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'required',
            'name' => 'required',
            'alamat' => 'nullable',
            'tempatLahir' => 'nullable',
            'tanggalLahir' => 'nullable',
            'pendidikanTerakhir' => 'nullable',
            'pekerjaan' => 'nullable',
            'penghasilan' => 'nullable',
            'noHp' => 'nullable',
            'role' => 'nullable',
            'email' => 'nullable',
            'bio' => 'nullable'
        ]);
        $userProfile = UserProfile::find($id);
        if (!$userProfile) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $userProfile->id_user = $request->input('id_user');
        $userProfile->name = $request->input('name');
        $userProfile->alamat = $request->input('alamat');
        $userProfile->tempatLahir = $request->input('tempatLahir');
        $userProfile->tanggalLahir = $request->input('tanggalLahir');
        $userProfile->pendidikanTerakhir = $request->input('pendidikanTerakhir');
        $userProfile->pekerjaan = $request->input('pekerjaan');
        $userProfile->penghasilan = $request->input('penghasilan');
        $userProfile->noHp = $request->input('noHp');
        $userProfile->role = $request->input('role');
        $userProfile->email = $request->input('email');
        $userProfile->bio = $request->input('bio');
        $userProfile->save();

        if ($request->has('id_user')) {
            $user = User::find($request->input('id_user'));
            $user->update(['name' => $request->input('name')]);
            $user->update(['role' => $request->input('role')]);
            $user->update(['email' => $request->input('email')]);
        }
        return $userProfile;
    }

    public function destroy($id)
    {
        $userProfile = UserProfile::find($id);
        if (!$userProfile) {
            return response()->json(['message' => 'User  Profile Tidak ditemukan'], 404);
        }

        $userProfile->delete();

        return response()->json(['message' => 'User Profile Dihapus']);
    }
}
