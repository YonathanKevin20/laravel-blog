<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Revision;
use DataTables;
use Auth;
use Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('post.index');
    }

    public function paginate(Request $request)
    {
        if(isset($request->search)) {
            $posts = Post::where('status','3')
                ->where(function($query) use($request) {
                    $query->where('title','like',"%$request->search%")
                        ->orWhere('slug','like',"%$request->search%")
                        ->orWhere('content','like',"%$request->search%")
                        ->orWhereHas('category', function($query) use($request) {
                            $query->where('name','like',"%$request->search%");
                        })
                        ->orWhereHas('user', function($query) use($request) {
                            $query->where('name','like',"%$request->search%");
                        });
                    })
                ->latest()
                ->paginate(5);

            $posts->appends($request->only('search'));
        }
        else {
            $posts = Post::where('status','3')
                ->latest()
                ->paginate(5);
        }

        $categories = Category::orderBy('name','ASC')->get();

        return view('paginate',compact('posts','categories'));
    }

    public function detail($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::orderBy('name','ASC')->get();

        return view('post.detail',compact('post','categories'));
    }

    public function search(Request $request)
    {
        if(isset($request->search)) {
            $posts = Post::where(function($query) use($request) {
                $query->where('title','like',"%$request->search%")
                    ->orWhere('slug','like',"%$request->search%")
                    ->orWhere('content','like',"%$request->search%")
                    ->orWhereHas('category', function($query) use($request) {
                        $query->where('name','like',"%$request->search%");
                    })
                    ->orWhereHas('user', function($query) use($request) {
                        $query->where('name','like',"%$request->search%");
                    });
                })
                ->latest()
                ->get();
            return view('post.search',compact('posts'));
        }
        else {
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name','ASC')->get();

        return view('post.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $image = $request->image;

        $path = $image->store('public/files');

        Post::create([
            'title' => $request->title,
            'slug' => str_slug($request->title),
            'content' => $request->content,
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'status' => '0',
            'image' => $path
        ]);

        return redirect()->route('post.index');
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

        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::orderBy('name','ASC')->get();
        $post = Post::findOrFail($id);

        return view('post.edit',compact('categories','post'));
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
        $post = Post::findOrFail($id);

        if($request->hasFile('image')) {
            $this->validate($request, [
                'title' => 'required',
                'content' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $image = $request->image;

            if(Storage::exists($post->image)) {
                Storage::delete($post->image);
            }

            $path = $image->store('public/files');
        }
        else {
            $path = $post->image;
        }

        if($post->status == '2') {
            $post->update([
                'title' => $request->title,
                'slug' => str_slug($request->title),
                'content' => $request->content,
                'category_id' => $request->category_id,
                'status' => '0',
                'image' => $path
            ]);
        }
        else {
            $post->update([
                'title' => $request->title,
                'slug' => str_slug($request->title),
                'content' => $request->content,
                'category_id' => $request->category_id,
                'image' => $path
            ]);
        }

        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        Storage::delete($post->image);
        $post->delete();

        return redirect()->route('post.index');
    }

    public function verification(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            'status' => $request->status
        ]);

        return response()->json($post);
    }

    public function revision(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            'status' => '2'
        ]);

        Revision::create([
            'note' => $request->note,
            'post_id' => $id,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('post.index');

    }

    public function approval(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            'status' => '3'
        ]);

        return response()->json($post);
    }

    public function getpost(Request $request)
    {
        $id = Auth::user()->id;
        switch (Auth::user()->role) {
            case 'editor':
                $posts = Post::with('category')->select('posts.*')->where('posts.user_id',$id)->latest();
                break;

            default:
                $posts = Post::with('category')->with('user')->select('posts.*')->latest();
                break;
        }

        return DataTables::eloquent($posts)
            ->addIndexColumn()
            ->editColumn('content', function ($posts) {
                return str_limit(strip_tags($posts->content),50);
            })
            ->toJson();
    }
}