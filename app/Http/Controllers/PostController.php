<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::all();
        //return response()->json(['data' => $posts], 200);
        return PostResource::collection(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:posts',
            'image' => 'required|mimes:jpg,png|max:200',
            'content' => 'required',
            'tags' => 'alpha_num'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }

        $data = $request->all();
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title);
        $data['slug'] = strtolower($slug);

        if($request->status == 'true')
            $data['status'] = Post::PUBLISHED;
        else
            $data['status'] = Post::DRAFT;


        if ($request->hasFile('image')) {
            $data['image'] = str_replace("public/", "", $request->image->store('public'));
        }

        $post = Post::create($data);

        return response()->json(['data' => $post], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json(['data' => $post], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'mimes:jpg,png|max:200',
            'content' => 'required',
            'tags' => 'alpha_num'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }


        if ($request->has('title')) {
            $post->title = $request->title;
        }

        if ($request->has('content')) {
            $post->content = $request->content;
        }

        if ($request->has('tags')) {
            $post->tags = $request->tags;
        }

        if ($request->has('status')) {
            if ($request->status == 'true')
                $post->status = Post::PUBLISHED;
            else
                $post->status = Post::DRAFT;
        }

        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title);
        $post->slug = strtolower($slug);


        if ($request->hasFile('image')) {
            Storage::delete($post->image);
            $post->image = str_replace("public/", "", $request->image->store('public'));
        }

        $post->save();

        return response()->json(['data' => $post], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        Storage::delete($post->image);

        return response()->json(['data' => $post], 200);
    }

    public function article($id){
        $post = Post::Published()->where('slug',$id)->get();
        if($post->count())
            return view('article',compact('post'));
        else
            abort(404);
    }
}
