<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\WorldController;
use App\Http\Controllers\World\CharacterController;
use App\Http\Controllers\World\EventController;
use App\Http\Controllers\World\ItemController;
use App\Http\Controllers\World\LocationController;
use App\Http\Controllers\World\OrganizationController;
use App\Models\World;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('update', function (Request $request) {
    if ($request->header('X-GitHub-Event') != 'push') {
        return response('OK', 200);
    }

    file_put_contents(
        'update.txt',
        shell_exec('sudo .././update.sh')
    );

    return response('OK', 200);
});

Route::get('/.well-known/acme-challenge/XY5kFEE95IBCU3YWZuo1_xvXSCMDGSxGFIya1tUg5ns', function () {
    return 'XY5kFEE95IBCU3YWZuo1_xvXSCMDGSxGFIya1tUg5ns.K5V5gEZp4lbeNgHuVy68NoNISr68BCckMtv9OY2ifAE';
});

Route::get('/', [IndexController::class, 'home'])->name('home');
Route::get('/privacy', [IndexController::class, 'privacy'])->name('privacy');
Route::get('/tos', [IndexController::class, 'tos'])->name('tos');
Route::get('/delete-fb-data', [IndexController::class, 'deleteFbData'])->name('delete-fb-data');
Route::get('/about', [IndexController::class, 'about'])->name('about');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/login', [SessionController::class, 'show'])->name('login');
Route::get('/auth/redirect/{service}', [SessionController::class, 'create']);
Route::get('/auth/callback/{service}', [SessionController::class, 'store']);
Route::get('/logout', [SessionController::class, 'destroy'])->name('logout');

//Blog
Route::resource('blog', BlogController::class)->parameter('blog', 'blogPost');
Route::get('/infinite-scroll', [BlogController::class, 'infiniteScrollView'])->name('blog.infinite-scroll');
Route::get('/blog/{id}/delete-confirm', [BlogController::class, 'deleteConfirm'])->name('blog.delete-confirm')->middleware('auth');
Route::post('/blog-draft', [BlogController::class, 'draft'])->name('blog.draft')->middleware('auth');
Route::put('/blog-draft', [BlogController::class, 'draft'])->name('blog.edit.draft')->middleware('auth');

//Blog Comments
Route::post('/blog/{id}/comment', [CommentController::class, 'blogComment'])->name('blog.comment')->middleware('auth');
Route::get('/blog/comment/{comment}/delete-confirm', [CommentController::class, 'blogCommentDeleteConfirm'])->name('blog.delete-comment-confirm')->middleware('auth');
Route::delete('/blog/comment/{comment}', [CommentController::class, 'blogCommentDelete'])->name('blog.delete-comment')->middleware('auth');

Route::resource('tag', TagController::class);
Route::resource('profile', ProfileController::class)->middleware('auth');

Route::post('/image-upload', [ImageController::class, 'store'])->name('image.upload')->middleware('auth');

Route::get('/social', [SocialController::class, 'buildFeed'])->name('social');


//Many Worlds
Route::resource('many-worlds', WorldController::class)->parameters([
    'many-worlds' => 'world'
])->scoped([
    'world' => 'short_name'
]);
Route::resource('many-worlds.locations', LocationController::class)->parameters([
    'many-worlds' => 'world'
])->scoped([
    'world' => 'short_name'
]);
Route::resource('many-worlds.organizations', OrganizationController::class)->parameters([
    'many-worlds' => 'world'
])->scoped([
    'world' => 'short_name'
]);
Route::resource('many-worlds.characters', CharacterController::class)->parameters([
    'many-worlds' => 'world'
])->scoped([
    'world' => 'short_name'
]);
Route::resource('many-worlds.items', ItemController::class)->parameters([
    'many-worlds' => 'world'
])->scoped([
    'world' => 'short_name'
]);
Route::resource('many-worlds.events', EventController::class)->parameters([
    'many-worlds' => 'world'
])->scoped([
    'world' => 'short_name'
]);

//World Comments
Route::post('/many-worlds/{world:short_name}/comment', [CommentController::class, 'worldComment'])->name('world.comment')->middleware('auth');
Route::get('/many-worlds/{world:short_name}/comment/{comment}/delete-confirm', [CommentController::class, 'worldCommentDeleteConfirm'])->name('world.delete-comment-confirm');
Route::delete('/many-worlds/{world:short_name}/comment/{comment}', [CommentController::class, 'worldCommentDelete'])->name('world.delete-comment');

//World Asset Comments
Route::post('/many-worlds/{world:short_name}/{assetType}/{assetId}/comment', [CommentController::class, 'worldAssetComment'])->name('world.asset.comment')->middleware('auth');
Route::get('/many-worlds/{world:short_name}/{assetType}/{assetId}/comment/{comment}/delete-confirm', [CommentController::class, 'worldAssetCommentDeleteConfirm'])->name('world.asset.delete-comment-confirm');
Route::delete('/many-worlds/{world:short_name}/{assetType}/{assetId}/comment/{comment}', [CommentController::class, 'worldAssetCommentDelete'])->name('world.asset.delete-comment');

Route::get('/test/many-worlds/{world:short_name}/{assetType}/{assetId}', function (World $world, string $assetType, int $assetId) {
    $asset = $world->$assetType()->findOrFail($assetId);
    return redirect()->route('many-worlds.'.$assetType.'.show', [$world, $asset]);
});
