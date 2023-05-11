<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = 'List Posts';

        $post_query = Post::withCount('comments');

        $filter = $request->query('category');
        $filter = trim(strip_tags($filter));

        if(!empty($filter)) {
            $post_query->whereHas('category', function ($query) use($filter) {
                $query->where('name', $filter);
            });
        }

        $keyword = $request->query('keyword');
        $keyword = trim(strip_tags($keyword));

        if(!empty($keyword)) {
            $post_query->where('title', 'LIKE', '%'. $keyword .'%');
        }

        $sort = $request->query('sortByComments');
        $sort = trim(strip_tags($sort));
        if(!empty($sort) && in_array($sort, ['asc', 'desc'])) {
            $post_query->orderBy('comments_count', $sort);
        }

        $data['categories'] = Category::orderBy('id', 'desc')->get();
        $data['posts'] = $post_query->orderBy('id', 'desc')->paginate(3);
        return view('posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Create Posts';
        $data['categories'] = Category::orderBy('id', 'desc')->get();
        $data['tags'] = Tag::orderBy('id', 'desc')->get();
        return view('posts.create', $data);
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
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048',
            'category' => 'required',
            'tags' => 'required|array'
        ], [
            'category.required' => 'Please select choose a category.',
            'tags.required' => 'Please select choose least one tag.'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/post_image'), $imageName);
        }

        $post = Post::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imageName,
            'user_id' => 1, // auth()->id() == auth()->user()->id
            'category_id' => $request->input('category')
        ]);

        $post->tags()->sync($request->input('tags'));

        return redirect()->route('posts.index')->with('success', 'Post Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['title'] = 'Show Post';
        $data['post'] = $post = Post::findOrFail($id);

//        if($post->user_id == auth()->id()) {
//            abort(403);
//        }

        return view('posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['post'] = Post::findOrFail($id);
        $data['categories'] = Category::orderBy('id', 'desc')->get();
        $data['tags'] = Tag::orderBy('id', 'desc')->get();
        return view('posts.edit', $data);
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

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'category' => 'required',
            'tags' => 'required|array'
        ], [
            'category.required' => 'Please select choose a category.',
            'tags.required' => 'Please select choose least one tag.'
        ]);

        $imageName = $post->image;
        if ($request->hasFile('image')) {
            //delete old image
            $path_image = public_path('uploads/post_image/'. $post->image);
            if(File::exists($path_image)) {
                File::delete($path_image);
            }
            // upload file
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/post_image'), $imageName);
        }

        $post->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imageName,
            'user_id' => 1, // auth()->id() == auth()->user()->id
            'category_id' => $request->input('category')
        ]);

        $post->tags()->sync($request->input('tags'));

        return redirect()->route('posts.index')->with('success', 'Post Successfully Updated');

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
        //delete old image
        $path_image = public_path('uploads/post_image/'. $post->image);
        if(File::exists($path_image)) {
            File::delete($path_image);
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post Successfully Deleted');
    }
}
