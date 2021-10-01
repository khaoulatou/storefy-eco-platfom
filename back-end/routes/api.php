<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\PixelController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SocialAuthController;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {

    // authentication routes :
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forget', [ResetController::class, 'forgotPassword']);
    Route::post('/reset', [ResetController::class, 'reset']);

    // country api :
    Route::get('/country', [CountryController::class, 'getAllCountry']);
    Route::post('/create-country', [CountryController::class, 'createCountry']);
    // authentication with social media :
    Route::get('/authorize/{provider}/redirect', [SocialAuthController::class, 'redirectToProvider']);
    Route::get('/authorize/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);

    // email activation :
    Route::post('resend', [EmailVerificationController::class, 'resendVerificationEmail'])->name('verification.resend');
    Route::get('verify-email', [EmailVerificationController::class, 'verify'])->name('verification.verify');

    //commande
    Route::get('showCommandes', [CommandeController::class, 'showCommandes']);
    Route::post('createCommande', [CommandeController::class, 'store']);
    Route::get('getCommandes', [CommandeController::class, 'index']);


    //produit
    Route::resource('/produit', ProduitController::class);
    // will be authenticated :
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // send activation email :
        Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->name('verification.send');

        // pixel functionality :
        Route::post('pixel/{id}', [PixelController::class, 'update']);
        Route::resource('pixel', PixelController::class)->except(['create', 'edit']);

        // logout
        Route::post('/logout', [AuthController::class, 'logout']);

        // update profile router :
        //        Route::post('/profile', [UserAuthentication::class, 'profile']);
    });
});
