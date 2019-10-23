<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePost;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('translations')->get();

        return view('admin.post.index')->with(compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePost $request)
    {
        $validated = $request->validated();

        $post = Post::create([
            'pl'  => ['name' => $validated['name_pl']],
            'en'  => ['name' => $validated['name_en']],
        ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Stanowisko '.$post->name.' zapisane.');

        return redirect()->route('admin.post.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $post->load('translations')->get();

        return view('admin.post.edit')->with(compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePost $request, Post $post)
    {
        $validated = $request->validated();

        $post->update([
            'pl'  => ['name' => $validated['name_pl']],
            'en'  => ['name' => $validated['name_en']],
        ]);

        $request->session()->flash('class', 'alert-info');
        $request->session()->flash('info', 'Stanowisko '.$post->name.' zapisane.');

        return redirect()->route('admin.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Request $request)
    {
        if(!count($post->people)) {
            $post->delete();

            $request->session()->flash('class', 'alert-info');
            $request->session()->flash('info', 'Stanowisko '.$post->name.' usunięte.');

            return redirect()->route('admin.post.index');
        } else {
            $request->session()->flash('class', 'alert-info');
            $request->session()->flash('info', 'Stanowisko jest przypisane do ankietowanych. Nie zostało usunięte.');

            return redirect()->route('admin.post.index');
        }
    }
}
