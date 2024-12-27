<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\User;

class CommentController extends Controller
{
    public function comment($id){
        try{
            $comment = Comment::where('blog_id', $id)->get();
            return response()->json([
                'comment' => $comment,
                'message'=>'all comments fetched successfully'
            ]);}
        catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to retrieve comments',
                'exception' => $e->getMessage(),
            ], 400);
        }

    }

    public function addComment(Request $request){
        try{
           $validatedData=  $request->validate([
                'content' => 'required',
                'blog_id' => 'required'
            ]);
            $validatedData['user_id'] = Auth::user()->id;
            $comment = new Comment();
            $comment->content = $validatedData['content'];
            $comment->user_id = $validatedData['user_id'];
            $comment->blog_id = $validatedData['blog_id'];
            $comment->save();
            return response()->json([
                'message' => 'Comment added successfully',
                'comment' => $comment
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to add comment',
                'error' => $e->getMessage(),
            ], 400);
        }


    }
    public function deleteComment($id){
        try{
            $comment = Comment::find($id);
            if($comment->user_id != Auth::user()->id){
                return response()->json([
                    'message' => 'You are not authorized to delete this comment',
                ], 401);
            }
            $comment->delete();
            return response()->json([
                'message' => 'Comment deleted successfully',
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to delete comment',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function updateComment(Request $request, $id){
        try{
            $comment = Comment::find($id);
            if($comment->user_id != Auth::user()->id){
                return response()->json([
                    'message' => 'You are not authorized to update this comment',
                ], 401);
            }
            $validatedData = $request->validate([
                'content' => 'required',
            ]);
            $comment->content = $validatedData['content'];
            $comment->save();
            return response()->json([
                'message' => 'Comment updated successfully',
                'comment' => $comment
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to update comment',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
