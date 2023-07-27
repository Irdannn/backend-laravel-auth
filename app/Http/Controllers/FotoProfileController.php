<?php

namespace App\Http\Controllers;

use App\Models\FotoProfile;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoProfileController extends Controller
{
    public function index()
    {
        $fotoProfile = FotoProfile::all()->toArray();
        return $fotoProfile;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_user' => 'required',
            'image_path' => 'required|mimes:jpeg,png|max:5000'
        ]);

        $fotoProfile = new FotoProfile();

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('pubic/pictures');
            $fotoProfile->id_user = $request->input('id_user');
            $fotoProfile->image_path = Storage::url($imagePath);
            $fotoProfile->save();

            return response()->json(['message' => 'Picture uploaded successfully']);
        }
    }

    public function show($id)
    {
        $imagePath = FotoProfile::findOrFail($id);

    if ($imagePath->image_path) {
        $storagePath = str_replace('storage/', '', $imagePath->image_path);
        $filePath = storage_path('app/' . $storagePath);

        if (file_exists($filePath)) {
            return response()->file($filePath);
        }
    }
    return response()->json(['error' => 'Picture not found'], 404);
    }

    public function update(Request $request, FotoProfile $fotoProfile)
    {
        //
    }

    public function destroy(FotoProfile $fotoProfile)
    {
        //
    }
}
