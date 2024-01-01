<?php

use App\Events\PostCreated;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::get('/create-post/{user_id}', function ($user_id) {

    $user = User::find($user_id);

    $post = $user->posts()->create([
        'title' => Str::random(50),
        'body' => Str::random(200),
        // 'user_id' => $user_id,
    ]);

    // event(new PostCreated($post));
    return $post;
    
});

Route::get('/create-post', function () {
    // $user = User::first();

    $post = Post::create([
        'title' => Str::random(50),
        'body' => Str::random(200),
        'user_id' => 11,
    ]);

    // event(new PostCreated($post));
    return 'ok';
    
});


Route::get('/', function () {
    return view('welcome');
});
