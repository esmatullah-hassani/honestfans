<?php

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

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PayPalPaymentController;
use App\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

    if(auth()->check()){
        return redirect("posts");
    }
    
    return view('auth.login');
});

Route::post("/resend-email/{email}/{name}/{id}","UsersController@sendEmail");
Route::post("/register-user","UsersController@registerUser")->name("registeruser");

//Route socialate
Route::get('authorized/google', 'LoginWithSocialiteController@redirectToGoogle');
Route::get('authorized/google/callback', 'LoginWithSocialiteController@handleGoogleCallback');
Route::get('/authorized/facebook', 'LoginWithSocialiteController@redirectTofacebook');
Route::get('/authorized/facebook/callback', 'LoginWithSocialiteController@handleFacebookCallback');

Auth::routes();
Route::get("/verify-user-email/{email}/{id}","UsersController@registerVerifyUser");
Route::middleware(['auth'])->group(function () {
    //Post routes
    Route::get('/posts', 'PostsController@index')->name('posts');
    Route::get('/posts/following', 'PostsController@following')->name('posts.following');
    Route::get('/posts/create', 'PostsController@create')->name('posts.create');
    Route::get('/posts/liked', 'PostsController@liked')->name('posts.liked');
    Route::get('/posts/{post}', 'PostsController@show')->name('posts.show');
    Route::get('/posts/{post}/edit', 'PostsController@edit')->name('posts.edit');
    Route::get("/posts/{id}/details","PostsController@postDetails")->name("posts.details");
    Route::put('/posts', 'PostsController@store')->name('posts.store');
    Route::post('/posts/{post}', 'PostsController@like')->name('posts.like');
    Route::patch('/posts/{post}', 'PostsController@update')->name('posts.update');
    Route::delete('/posts/{post}', 'PostsController@destroy')->name('posts.destroy');
    Route::get("/multiplevideos",function(){
        return view("posts.multipleimage");
    });
    Route::post("/multiplevideos","PostsController@storeMultiplevideo")->name("multiplevideos.store");

    //Users
    Route::get('/account/settings', 'UsersController@settings')->name('account');
    Route::get('/user/{user}', 'UsersController@show')->name('account.show');
    Route::get("/get-users/{name}","UsersController@getUsers");
    Route::patch('/account/settings', 'UsersController@update')->name('account.update');
    Route::post('/user/{user}', 'UsersController@follow')->name('account.follow');
  
    //When logged in: Redirect /account to current users profile, /user/1 etc.
    Route::get('/account', function () {
        return redirect()->route('account.show', ['id' => Auth::id()]);
    });

    //Comments route
    Route::post("comment","CommentController@store")->name('comment');

    Route::get('storage/{filename}', function ($filename)
    {
        $path = storage_path('video/' . $filename);

        return \Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'video/webm',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);

    })->name('get-video');

   // Route::get("/chats",[ChatController::class,'index'])->name("chats");
    // Endpoints to call or receive calls.
    Route::post('/video/call-user', [ChatController::class,'callUser']);
    Route::post('/video/accept-call', [ChatController::class,'acceptCall']);

    Route::get("/users/message/{user_1}/{user_2}",[MessageController::class,'index']);
    Route::post("/users/message",[MessageController::class,'store']);

});
Route::get('/video-chat', function () {
    // fetch all users apart from the authenticated user
    $users = User::where('id', '<>', Auth::id())->get();
    return view('chats.chat', ['users' => $users]);
})->name("chats");

//paypal
// Route::post("/payments/purchase-with-paypal",[
//     'uses' => [PaypalController::class,'purchaseWithPaypal']
// ])->name('payments.purchase');

// Route::get("/payments/pusrchase-status",[
//     'uses' => [PaypalController::class,'getPaypalPaymentStatus']
// ]);

Route::get("/pay",function(){
    return view("paypal.product");
});

Route::get('handle-payment', [PayPalPaymentController::class,'handlePayment'])->name('make.payment');
Route::get('cancel-payment', [PayPalPaymentController::class,'paymentCancel'])->name('cancel.payment');
Route::get('payment-success', [PayPalPaymentController::class,'paymentSuccess'])->name('success.payment');



//Route::post('auth/video_chat', [ChatController::class,'videoChat']);
