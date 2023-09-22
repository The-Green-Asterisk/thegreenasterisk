<?php

namespace App\Http\Controllers;

use App\Mail\CommentMail;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\Tag;
use App\View\Components\Modal;
use Auth;
use Illuminate\Http\Request;
use Mail;
use Storage;
use Str;

class BlogController extends Controller
{
    private function infiniteScroll(Request $request)
    {
        $tag = $request->query('tag');
        $drafts = $request->query('drafts') ?? false;
        $all = $request->query('all') ?? false;
        $page = $request->query('page') ?? 0;

        if ($all) {
            $posts = BlogPost::getAll()
                ->skip($page * 10)
                ->take(10)
                ->get();
        } else {
            $tag
            ? $posts = BlogPost::whereHas('tags', function ($query) use ($tag) {
                $query->where('name', $tag);
            })->where('is_draft',
                (auth()->check() && Auth::user()->isAdmin())
                    ? $drafts
                    : false)
                ->latestFirst()
                ->skip($page * 10)
                ->take(10)->get()
            : $posts = BlogPost::where('is_draft',
                (auth()->check() && Auth::user()->isAdmin())
                    ? $drafts
                    : false)
                ->latestFirst()
                ->skip($page * 10)
                ->take(10)->get();
        }

        $imgs = Storage::disk('public')->files('images/random');
        $backupImg = $imgs[array_rand($imgs)];
        $nullPost = new BlogPost([
            'id' => 0,
            'image' => 'storage/'.$backupImg,
            'title' => 'No blog posts',
            'content' => 'Nothing to see here',
            'user_id' => 1,
        ]);
        $posts = $posts->count() ? $posts : collect([$nullPost]);

        if ($posts[$posts->count() - 1]->id == 0 && $page > 0) {
            return null;
        } else {
            $posts->draft_count = BlogPost::where('is_draft', true)->count();

            return $posts;
        }
    }

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['store', 'create', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $posts = $this->infiniteScroll($request);

        return view('blog.index', compact('posts'));
    }

    public function infiniteScrollView(Request $request)
    {
        $posts = $this->infiniteScroll($request);

        if ($posts) {
            return view('components.blog-post-view', compact('posts'))->render();
        } else {
            return null;
        }
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

        $imgUrl = $request->file('image')?->store('storage/images');

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

        $newPublish = $blogPost->is_draft && ! $draft;

        $blogPost->title = $request->title;
        $blogPost->content = $request->content;
        if ($request->image) {
            $blogPost->image = 'storage/'.$request->file('image')->store('storage/images');
        }
        $blogPost->is_draft = $draft;
        if ($newPublish) {
            $blogPost->published_at = now();
        }
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

    public function comment(Request $request, int $blogId)
    {
        $this->validate($request, [
            'comment_content' => 'required|min:5',
        ]);

        $blogPost = BlogPost::find($blogId);
        $blogPost->comments()->create([
            'content' => $request->comment_content,
            'user_id' => auth()->id(),
            'blog_post_id' => $blogPost->id,
        ]);

        $data = [
            'comment' => $request->comment_content,
            'post' => $blogPost,
        ];

        Mail::to(config('mail.from.address'))->send(new CommentMail($data));

        return redirect()->route('blog.show', $blogPost);
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
