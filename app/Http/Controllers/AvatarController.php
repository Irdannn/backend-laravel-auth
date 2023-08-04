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
        $images=new Avatar();
        $request->validate([
            'user_uuid'=>'required',
            'image'=>'required|max:1024'
        ]);

        $filename="";
        if($request->hasFile('image')){
            $filename=$request->file('image')->store('pubic/pictures');
            $images->image = Storage::url($filename);
        }else{
            $filename=Null;
        }

        $images->user_uuid=$request->user_uuid;
        $images->image=$filename;
        $result=$images->save();
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
        
    }

    public function show($uuid)
    {
        $imagePath = Avatar::findOrFail($uuid);

    if ($imagePath->image) {
        $storagePath = str_replace('storage/', '', $imagePath->image);
        $filePath = storage_path('app/' . $storagePath);

        if (file_exists($filePath)) {
            return response()->file($filePath);
        }
    }
    return response()->json(['error' => 'Picture not found'], 404);
    }

    public function update(Request $request, $uuid)
    {
        $images=Avatar::findOrFail($uuid);
        
        $destination=public_path("storage\\".$images->image);
        $filename="";
        if($request->hasFile('new_image')){
            if(File::exists($destination)){
                File::delete($destination);
            }

            $filename=$request->file('new_image')->store('pubic/pictures');
            $images->image = Storage::url($filename);
        }else{
            $filename=$request->image;
        }

        $images->user_uuid=$request->user_uuid;
        $images->image=$filename;
        $result=$images->save();
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }


    public function delete($uuid)
    {
        $images=Avatar::findOrFail($uuid);
        $destination=public_path("storage\\".$images->image);
        if(File::exists($destination)){
            File::delete($destination);
        }
        $result=$images->delete();
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }

    public function get()
    {
        $images=Avatar::orderBy('uuid','DESC')->get();
        return response()->json($images);
    }

    public function edit($uuid)
    {
        $images=Avatar::findOrFail($uuid);
        return response()->json($images);
    }
}
