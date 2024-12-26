<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Blog;

class ImageController extends Controller
{
    public function storeImage(Request $request, $id){
        try{
            if($request->hasFile('image')){
                $image = $request->file('image');
                $path = $image->storeAs('public/images',$image->getClientOriginalName());
            }
            $image = new Image();
            $image->image = $path;
            $image->blog_id = $request->id;
            $image->save();
            return response()->json([
                'message' => 'Image uploaded successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Image is not uploaded',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
