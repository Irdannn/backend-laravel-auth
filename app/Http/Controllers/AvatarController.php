<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function create(Request $request)
    {
        $avatars=new Avatar();
        $request->validate([
            'user_id'=>'required',
            'avatar'=>'required|max:1024'
        ]);

        $filename="";
        if($request->hasFile('avatar')){
            $filename=$request->file('avatar')->store('pubic/pictures');
            $avatars->avatar = Storage::url($filename);
        }else{
            $filename=Null;
        }

        $avatars->user_id=$request->user_id;
        $avatars->avatar=$filename;
        $result=$avatars->save();
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
        
    }

    public function show($id)
    {
        $avatarPath = Avatar::findOrFail($id);

    if ($avatarPath->avatar) {
        $storagePath = str_replace('storage/', '', $avatarPath->avatar);
        $filePath = storage_path('app/' . $storagePath);

        if (file_exists($filePath)) {
            return response()->file($filePath);
        }
    }
    return response()->json(['error' => 'Picture not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $avatars=Avatar::findOrFail($id);
        
        $destination=public_path("storage\\".$avatars->avatar);
        $filename="";
        if($request->hasFile('new_avatar')){
            if(File::exists($destination)){
                File::delete($destination);
            }

            $filename=$request->file('new_avatar')->store('pubic/pictures');
            $avatars->avatar = Storage::url($filename);
        }else{
            $filename=$request->avatar;
        }

        $avatars->user_id=$request->user_id;
        $avatars->avatar=$filename;
        $result=$avatars->save();
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }


    public function delete($uuid)
    {
        $avatars=Avatar::findOrFail($uuid);
        $destination=public_path("storage\\".$avatars->avatar);
        if(File::exists($destination)){
            File::delete($destination);
        }
        $result=$avatars->delete();
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }

    public function get()
    {
        $avatars=Avatar::orderBy('uuid','DESC')->get();
        return response()->json($avatars);
    }

    public function edit($uuid)
    {
        $avatars=Avatar::findOrFail($uuid);
        return response()->json($avatars);
    }
}
