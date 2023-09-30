<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\CommentMail;
use App\Models\Comment;
use App\Models\BlogPost;
use App\Models\World;
use App\View\Components\Modal;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function blogComment(Request $request, int $blogId)
    {
        $this->validate($request, [
            'comment_content' => 'required|min:5',
        ]);
        
        $comment = new Comment([
            'content' => $request->comment_content,
            'user_id' => auth()->user()->id,
        ]);

        $blogPost = BlogPost::findOrFail($blogId);
        $blogPost->comments()->save($comment);

        $data = [
            'comment' => $request->comment_content,
            'post' => $blogPost,
        ];

        Mail::to(config('mail.from.address'))->send(new CommentMail($data));

        return redirect()->route('blog.show', $blogPost);
    }

    public function blogCommentDelete(Comment $comment)
    {
        $blogPost = $comment->commentable()->first();
        $comment->delete();

        return redirect()->route('blog.show', $blogPost->id);
    }

    public function blogCommentDeleteConfirm(Comment $comment)
    {
        $modal = new Modal(
            'Are you sure?',
            view('components.modal.modals.delete.delete', compact('comment')),
            'Delete',
            'Cancel',
        );

        return $modal->render();
    }

    public function worldComment(Request $request, World $world)
    {
        $this->validate($request, [
            'comment_content' => 'required|min:5',
        ]);
        
        $comment = new Comment([
            'content' => $request->comment_content,
            'user_id' => auth()->user()->id,
        ]);

        $world->comments()->save($comment);

        $data = [
            'comment' => $request->comment_content,
            'post' => $world,
            'email' => config('mail.from.address') //change this to the user who made the world when that's implemented
        ];

        Mail::to(config('mail.from.address'))->send(new CommentMail($data));

        return redirect()->route('many-worlds.show', $world);
    }

    public function worldCommentDelete(World $world, Comment $comment)
    {
        $comment->delete();

        return redirect()->route('many-worlds.show', $world);
    }

    public function worldCommentDeleteConfirm(World $world, Comment $comment)
    {
        $modal = new Modal(
            'Are you sure?',
            view('components.modal.modals.delete.delete', compact('comment')),
            'Delete',
            'Cancel',
        );

        return $modal->render();
    }

    public function worldAssetComment(Request $request, World $world, string $assetType, int $assetId)
    {
        $this->validate($request, [
            'comment_content' => 'required|min:5',
        ]);
        
        $comment = new Comment([
            'content' => $request->comment_content,
            'user_id' => auth()->user()->id,
        ]);

        $asset = $world->$assetType()->findOrFail($assetId);
        $asset->comments()->save($comment);

        $data = [
            'comment' => $request->comment_content,
            'post' => $asset,
            'email' => config('mail.from.address') //change this to the user who made the world when that's implemented
        ];

        Mail::to(config('mail.from.address'))->send(new CommentMail($data));

        return redirect()->route('many-worlds.'.$assetType.'.show', [$world, $asset]);
    }

    public function worldAssetCommentDelete(World $world, string $assetType, int $assetId, Comment $comment)
    {
        $asset = $world->$assetType()->findOrFail($assetId);
        $comment->delete();

        return redirect()->route('many-worlds.'.$assetType.'.show', [$world, $asset]);
    }

    public function worldAssetCommentDeleteConfirm(Comment $comment)
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
