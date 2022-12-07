<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorContainer;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function saveRecord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'description' => 'required|max:250',
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5048',
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => ErrorContainer::errorValidator($validator),
            ], 422);
        }

        if ($request->hasFile('file')) {
            $image = $request->file->store('public');
            $post = new Post();
            $post->name = $request->name;
            $post->description = $request->description;
            $post->file = $image;
            $post->type = $request->type;

            $post->save();
        } else {
            $post = new Post();
            $post->name = $request->name;
            $post->description = $request->description;
            $post->file = "";
            $post->type = $request->type;
        }

        return response()->json([
            'success' => true,
            'message' => 'Record Saved Successfully',
            'data' => $post
        ], 200);
    }

    public function listRecord(Request $request)
    {
        $list = Post::paginate(10);
        
        return response()->json([
            'success' => true,
            'message' => 'List of Records',
            'data' => $list
        ], 200);
    }

    
    public function temporary(Request $request, $path)
    {
        $disk = Storage::disk('public');
        return $disk->temporaryUrl($path, now()->addMinutes(10));
    }

    public function detailRecord(Request $request, $id)
    {
        $detailRecord = Post::where('id', $id)->first();
        if($detailRecord){   
            return response()->json([
                'success' => true,
                'message' => 'Record Detail',
                'data' => $detailRecord,
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No record found',
            ], 200);   
        }
    }
}
