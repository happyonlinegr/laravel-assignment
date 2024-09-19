<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(Request $request):JsonResponse{
        try{
            $posts = Post::query()
                ->author($request->input('author'))
                ->tag($request->input('tag'))
                ->category($request->input('category'))
                ->get()
                ->load('users')
                ->load('tags');
            
            if($posts->isEmpty()){
                return response()->json('No posts found',404);
            }

            return response()->json(PostResource::collection($posts),200);
        }
        catch(Exception $e){
            return response()->json(['error'=>'Internal Server Error.','message'=>$e->getMessage()],404);
        }
    }

    public function store(Request $request):JsonResponse{
        try{
            $validate = Validator::make($request->all(),[
                'title' => ['required','string','max:255'],
                'content' =>  ['required','string','max:255'],
                'author' =>  ['required','exists:users,id',],
                'categories' => ['array'],
                'categories.*' => ['exists:categories,id',],
                'tags' => ['array'],
                'tags.*' => ['exists:tags,id',]
            ]);

            if($validate->fails()){
                return response()->json([
                    'error'=>'Post could not be created.',
                    'message'=>$validate->errors()],422);
            }

            $post = Post::create([
                'title'=>$request['title'],
                'content'=>$request['content'],
                'author'=>$request['author'],
                'slug' => str_replace(' ','_',strtolower($request['title']))
            ]);

            $post->tags()->attach($request['tags']);

            $post->categories()->attach($request['categories']);

            $post->load('tags')->load('categories')->load('users');
            
            return response()->json(new PostResource($post),200);
        }
        catch(Exception $e){
            return response()->json(['error'=>'Internal Server Error.','message'=>$e->getMessage()],404);
        }
    }

    public function show(Request $request):JsonResponse{

        try{

            $validate = Validator::make($request->all(),[
                'id' => 'nullable|integer|exists:posts,id',
                'slug' => 'nullable|string|exists:posts,slug', 
            ]);
            if($validate->fails()){
                return response()->json(['error'=>'Validation failed.','message'=>$validate->errors()],422);
            }

            $post = Post::with(['users','tags'])
                ->where('id', $request->id)
                ->where('slug', $request->slug)
                ->first();
              
            
            if(!$post){
                return response()->json(['error'=>'Post not found.'],404);
            }

            return response()->json( new PostResource($post),200);
        }
        catch(Exception $e){
            return response()->json(['error'=>'Internal Server Error.','message'=>$e->getMessage()],500);
        }
    }

    public function update(Request $request,$id):JsonResponse{
        try{

            $validateId = Validator::make(['id'=>$id],[
                'id' => ['required','integer','exists:posts,id']
            ]);
            if($validateId->fails()){
                return response()->json([
                    'message' => 'Post could not be updated,invalid data provided',
                    'errors' => $validateId->errors()],404);
            }


            $validateData = Validator::make($request->all(),[
                'title' => ['string','max:255'],
                'content' =>  ['string','max:255'],
                'author' =>  ['exists:users,id',],
                'categories' => ['array'],
                'categories.*' => ['exists:categories,id',],
                'tags' => ['array'],
                'tags.*' => ['exists:tags,id',]
            ]);

            if($validateData->fails()){
                return response()->json(
                    ['message' => 'Post could not be updated,invalid data provided.',
                    'errors' => $validateData->errors()],422);
            }

            $post = Post::find($id);

            if(!$post){
                return response()->json('Post not bfound.',404);
            }

            $data = $validateData->validated();

            if(array_key_exists('title',$data)){
               $data['slug'] = str_replace(' ','_',strtolower($data['title']));
            }

            if(array_key_exists('categories',$data)){
                $post->categories()->sync($data['categories']);
            }

            if(array_key_exists('tags',$data)){
                $post->tags()->sync($data['tags']);
            }

            $post->update($data);
            
            $post->load('users')->load('tags')->load('categories');
    
            return response()->json(new PostResource($post),200);
        }
        catch(Exception $e){
            return response()->json(['error'=>'Internal Server Error.','message'=>$e->getMessage()],500);
        }
    }

    public function destroy($id){
        try{

            $post = Post::find($id);

            $validateId = Validator::make(['id'=>$id],[
                'id' => ['required','integer','exists:posts,id']
            ]);
            if($validateId->fails()){
                return response()->json([
                    'message' => 'Post could not be deleted.',
                    'errors' => $validateId->errors()],404);
            }

            if (!$post) {
                return response()->json(['message' => 'Post not found'], 404);
            }

            $post->categories()->detach();

            $post->tags()->detach();

            $post->delete();

            return response()->json(['message' => 'Post deleted successfully'], 200);
        }
        catch(Exception $e){
            return response()->json(['error'=>'Internal Server Error.','message'=>$e->getMessage()],500);
        }
    }

    public function postsByUser($id):JsonResponse{
        try{
            $validateId = Validator::make(['id'=>$id],[
                'id' =>  ['required','integer','exists:users,id'],
            ]);
            if($validateId->fails()){
                return response()->json(['error'=>'Posts could not be found.','message'=>$validateId->errors()],404);
            }

            $posts = Post::where('author',$id)->with('categories')->get();
            if($posts->isEmpty()){
                return response()->json(['error'=>'Posts could not be found.','message'=>'user has no posts.'],404);
            }

            return response()->json(PostResource::collection($posts),200);
        }
        catch(Exception $e){
            return response()->json(['error'=>'Internal Server Error.','message'=>$e->getMessage()],500);
        }
    }

}
