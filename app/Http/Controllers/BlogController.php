<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\Tag;
use App\View\Components\Modal;
use Auth;
use Illuminate\Http\Request;
use Storage;
use Str;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['store', 'create', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $tag = $request->query('tag');
        $drafts = $request->query('drafts') ?? false;
        $all = $request->query('all') ?? false;

        $posts = collect();

        $tag
            ? $posts = BlogPost::getAllByTag($tag)
            : $posts = BlogPost::latestFirst()->get();

        if (auth()->check() && Auth::user()->isAdmin()) {
            if (! $all) {
                $posts = $posts->where('is_draft', $drafts);
            }
        } else {
            $posts = $posts->where('is_draft', false);
        }

        $imgs = Storage::disk('public')->files('images/random');
        $backupImg = $imgs[array_rand($imgs)];
        $posts = $posts->count() ? $posts : collect([new BlogPost([
            'id' => 0,
            'image' => 'storage/'.$backupImg,
            'title' => 'No blog posts',
            'content' => 'Nothing to see here',
            'user_id' => 1,
        ])]);

        return view('blog.index', compact('posts'));
    }

    public function show(BlogPost $blogPost)
    {
        return view('blog.show', compact('blogPost'));
    }

    public function create()
    {
        $tags = Tag::all();

        return view('blog.create', compact('tags'));
    }

    public function store(Request $request, $draft = false)
    {
        $this->validate($request, [
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:10',
            'image' => 'image|max:2048000',
            'tags' => 'array|min:1',
        ]);

        // Get all the images from the random folder
        $imgs = Storage::disk('public')->files('images/random');
        // Get a random image from the random folder
        $backupImg = $imgs[array_rand($imgs)];

        $imgUrl = $request->file('image')->store('images');

        $post = new BlogPost();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->image = 'storage/'.($imgUrl ?? $backupImg);
        $post->slug = Str::slug($request->title);
        $post->user_id = auth()->id();
        $post->is_draft = $draft;
        $post->published_at = $draft ? null : now();
        $post->save();

        $post->tags()->sync($request->tags);

        return redirect()->route('blog.index');
    }

    public function draft(Request $request)
    {
        if (BlogPost::where('id', $request->id)->exists()) {
            return $this->update($request, BlogPost::find($request->id), true);
        } else {
            return $this->store($request, true);
        }
    }

    public function edit(BlogPost $blogPost)
    {
        $tags = Tag::all();

        return view('blog.edit', compact('blogPost', 'tags'));
    }

    public function update(Request $request, BlogPost $blogPost, $draft = false)
    {
        $this->validate($request, [
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:10',
            'image' => 'image|max:2048000',
            'tags' => 'array|min:1',
        ]);

        $blogPost->title = $request->title;
        $blogPost->content = $request->content;
        if ($request->image) {
            $blogPost->image = 'storage/'.$request->file('image')->store('images');
        }
        $blogPost->is_draft = $draft;
        $blogPost->published_at = $draft ? null : now();
        $blogPost->save();

        $blogPost->tags()->sync($request->tags);

        return redirect()->route('blog.show', $blogPost);
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->tags()->detach();
        $blogPost->delete();

        return redirect()->route('blog.index');
    }

    public function deleteConfirm(BlogPost $blogPost)
    {
        $modal = new Modal(
            'Are you sure?',
            view('components.modal.modals.delete.delete', compact('blogPost')),
            'Delete',
            'Cancel',
        );

        return $modal->render();
    }

    public function comment(Request $request, BlogPost $blogPost)
    {
        $this->validate($request, [
            'comment_content' => 'required|min:5',
        ]);

        $blogPost = BlogPost::find($request->blog_post_id);

        $blogPost->comments()->create([
            'content' => $request->comment_content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back();
    }

    public function commentDelete(Comment $comment)
    {
        $blogPost = $comment->blogPost;

        $comment->blogPost()->dissociate();
        $comment->delete();

        return redirect()->route('blog.show', $blogPost);
    }

    public function commentDeleteConfirm(Comment $comment)
    {
        $modal = new Modal(
            'Are you sure?',
            view('components.modal.modals.delete.delete', compact('comment')),
            'Delete',
            'Cancel',
        );

        return $modal->render();
    }
}
