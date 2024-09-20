<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request , $id):JsonResponse{
        try{
            $userid = Auth::user()->id;
            $validateId = Validator::make(['id'=>$id],[
                'id' =>  ['required','integer','exists:posts,id'],
            ]);
            if($validateId->fails()){
                return response()->json(['error'=>'Comment could not be created','message'=>'post was not found.'],404);
            }

            $validatedRequest = Validator::make($request->all(),[
                'content' =>  ['required','string','max:255'],
            ]);
            if($validatedRequest->fails()){
                return response()->json(['error'=>'Comment could not be created.','message'=>$validatedRequest->errors()],422);
            }

            $comment = Comment::create([
                'post_id'=>$id,
                'user_id'=>$userid,
                'content'=>$request['content'],
            ]);

            $comment->load('user')->load('post');
            
            return response()->json(new CommentResource($comment),200);        
        }
        catch(Exception $e){
            return response()->json(['error'=>'Internal Server Error.','message'=>$e->getMessage()],500);
        }
    }

    public function commentsByUser($id):JsonResponse{
        try{
            $validateId = Validator::make(['id'=>$id],[
                'id' =>  ['required','integer','exists:users,id'],
            ]);
            if($validateId->fails()){
                return response()->json(['error'=>'Comments not found.','message'=>$validateId->errors()],404);
            }

            $comments = Comment::authorPost($id)->get();
            if($comments->isEmpty()){
                return response()->json(['error'=>'Posts could not be found.','message'=>'user has no posts.'],404);
            }

            return response()->json(CommentResource::collection($comments),200);

        }
        catch(Exception $e){
            return response()->json(['error'=>'Internal Server Error.','message'=>$e->getMessage()],500);
        }
    }
}
