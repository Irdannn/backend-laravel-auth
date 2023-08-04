<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;


class UserProfileController extends Controller
{
    public function index()
    {
        $userProfile = UserProfile::all()->toArray();
       return $userProfile;
    }
    public function show($user_uuid)
    {
        return UserProfile::find($user_uuid);
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'user_uuid' => 'required',
            'username' => 'required',
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

        $userProfile = UserProfile::find($uuid);
        if (!$userProfile) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $userProfile->user_uuid = $request->input('user_uuid');
        $userProfile->username = $request->input('username');
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

        if ($request->has('user_uuid')) {
            $user = User::find($request->input('user_uuid'));
            $user->update(['username' => $request->input('username')]);
            $user->update(['name' => $request->input('name')]);
            $user->update(['role' => $request->input('role')]);
            $user->update(['email' => $request->input('email')]);
        }
        return $userProfile;
    }

    public function destroy($uuid)
    {
        $userProfile = UserProfile::find($uuid);
        if (!$userProfile) {
            return response()->json(['message' => 'User  Profile Tidak ditemukan'], 404);
        }

        $userProfile->delete();

        return response()->json(['message' => 'User Profile Dihapus']);
    }
}
