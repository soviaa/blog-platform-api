<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\User;



class BlogController extends Controller
{
    public function viewBlog(){
        $blog = Blog::all();

        return response()->json([
            'blog' => $blog,
            'message'=>'all blogs fetched successfully'
        ]);
    }
    public function viewSingleBlog($id){
        $blog = Blog::with('user')->where('id', $id)->first();
        return response()->json([
            'blog' => $blog,
            'message'=>'blog fetched successfully'
        ]);
    }

    public function addBlog(Request $request){
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $validatedData['author'] = Auth::user()->username;
        if(!$validatedData['author']){
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        $blog = new Blog();
        $blog->title = $validatedData['title'];
        $blog->content = $validatedData['content'];
        $blog->author = $validatedData['author'];
        $blog->save();
        return response()->json([
            'blog' => $blog,
            'message' => 'blog created successfully'
        ]);
    }

    public function updateBlog(Request $request, $id){
        $validatedData = $request->validate([
            'title' => 'required|sometimes',
            'content' => 'required|sometimes',
        ]);

        $blog = Blog::find($id);
        if(!$blog){
            return response()->json([
                'message' => 'Blog not found'
            ], 404);
        }

        if($blog->author != Auth::user()->username){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $blog->title = $validatedData['title'] ?? $blog->title;
        $blog->content = $validatedData['content'] ?? $blog->content;
        $blog->save();
        return response()->json([
            'blog' => $blog,
            'message' => 'blog updated successfully'
        ]);
    }

    public function deleteBlog($id){
        $blog = Blog::find($id);
        if(!$blog){
            return response()->json([
                'message' => 'Blog not found'
            ], 404);
        }
        if($blog->author != Auth::user()->username){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $blog->delete();
        return response()->json([
            'message' => 'blog deleted successfully'
        ]);
    }
}
