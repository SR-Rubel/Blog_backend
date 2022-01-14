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
            $thrumbnail_f=$image_f=uniqid();
            Image::make($image)->save(public_path('images/original/'.$image_f.'.jpg').'',100,'jpg');
            Image::make($image)->resize(300,200)->save(public_path('images/thrumbnail/'.$image_f.'_thrumbnail.jpg').'',100,'jpg');
            $post['image']=$image_f.'.jpg';
            $post['thrumbnail']=$thrumbnail_f.'_thrumbnail.jpg';
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
        return $this->oneResponse($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        return $this->customResponse(['msg'=>'post deleted!']);
    }
}
