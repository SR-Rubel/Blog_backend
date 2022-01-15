<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post=Post::paginate(15);
        return $this->customResponse(["data"=>$post]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'slug' =>'unique:posts',
        ]);

        $post=$request->all();
        $image=$request->image;
        $post['image']=$image;
        if($image){
            $thumbnail_f=$image_f=uniqid();
            Image::make($image)->save(public_path('storage/images/original/'.$image_f.'.jpg').'',100,'jpg');
            Image::make($image)->resize(300,200)->save(public_path('storage/images/thumbnail/'.$image_f.'_thumbnail.jpg').'',100,'jpg');
            $post['image']=$image_f.'.jpg';
            $post['thumbnail']=$thumbnail_f.'_thumbnail.jpg';
        }
        Post::create($post);
        return $this->customResponse(['msg'=>'post created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $image='';
        if($post->image) $image=asset('storage/images/thumbnail/'.$post->thumbnail);
        $post['image_link']= $image;
        return $this->oneResponse($post);
        // return $this->customResponse(['image'=>$image]);
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
        $request->validate([
            'title'=>'required',
            'slug' =>'unique:posts',
        ]);

        if($request->slug )$post->slug= $request->slug;
        if($request->title) $post->title= $request->title;
        if($request->body) $post->body= $request->body;

        if($request->image){
            $image='';
            $thumbnail_f=$image_f=uniqid();
            Image::make($image)->save(public_path('storage/images/original/'.$image_f.'.jpg').'',100,'jpg');
            Image::make($image)->resize(300,200)->save(public_path('storage/images/thumbnail/'.$image_f.'_thumbnail.jpg').'',100,'jpg');

            // deleting existing image
            // if(file_exists(public_path('storage/images/original/').$post->image))
            // {
            //     unlink(public_path('storage/images/original/').$post->image);
            //     unlink(public_path('storage/images/thumbnail/').$post->thumbnail);
            // }

            $post['image']=$image_f.'.jpg';
            $post['thumbnail']=$thumbnail_f.'_thumbnail.jpg';
        }
       $res = $post->save();
        return $this->customResponse(['msg'=>'post updated']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $deleted_post=$post->delete();
        if(file_exists(public_path('storage/images/original/').$post->image))
        {
            unlink(public_path('storage/images/original/').$post->image);
            unlink(public_path('storage/images/thumbnail/').$post->thumbnail);
        }

        return $this->customResponse(['msg'=>'post deleted!']);
    }

    public function showBySlug($slug){
        $post=Post::where('slug',$slug)->get();
        return $post;
    }
}
