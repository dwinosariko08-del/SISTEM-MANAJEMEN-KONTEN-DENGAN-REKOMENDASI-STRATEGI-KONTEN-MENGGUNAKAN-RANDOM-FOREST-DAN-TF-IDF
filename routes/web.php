<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\Leader\ContentPlanController;
use App\Http\Controllers\Editor\EditorContentController;
use App\Http\Controllers\Editor\EditorTaskController;
use App\Http\Controllers\Editor\ProducedVideoController;
use App\Http\Controllers\Editor\ContentAnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Editor\RecommendationController;
use App\Http\Controllers\Leader\RecommendationController as LeaderRecommendationController;
/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $publishedContent = \App\Models\ContentPlan::where('status', 'published')->count();
    $activeAssets = \App\Models\Asset::count();
    $latestProject = \App\Models\ContentPlan::with('editorContent')->where('status', 'published')->latest()->first();

    return view('welcome', compact('publishedContent', 'activeAssets', 'latestProject'));
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // =========================
    // GENERAL DASHBOARD
    // =========================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // =========================
    // PROFILE (OPTIONAL - BAWAAN BREEZE)
    // =========================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =========================
    // ASSET MANAGEMENT
    // =========================

    // TIM LAPANGAN (UPLOAD & LIHAT ASSET SENDIRI)
    Route::middleware('role:lapangan')->group(function () {
        Route::get('/assets/create', [AssetController::class, 'create'])->name('assets.create');
        Route::post('/assets', [AssetController::class, 'store'])->name('assets.store');
    });

    // SEMUA ROLE (LIHAT ASSET)
    Route::middleware('role:leader,editor,lapangan')->group(function () {
        Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
    });



// =========================
// LEADER MANAGEMENT
// =========================
Route::middleware(['auth', 'role:leader'])
    ->prefix('leader')
    ->name('leader.')
    ->group(function () {

    /* ======================
       CONTENT CRUD
    ====================== */
    Route::get('/contents', [ContentPlanController::class, 'index'])
        ->name('contents.index');

    Route::get('/contents/create', [ContentPlanController::class, 'create'])
        ->name('contents.create');

    Route::post('/contents', [ContentPlanController::class, 'store'])
        ->name('contents.store');

    Route::get('/contents/{content}', [ContentPlanController::class, 'show'])
        ->name('contents.show');

    Route::get('/contents/{content}/edit', [ContentPlanController::class, 'edit'])
        ->name('contents.edit');

    Route::put('/contents/{content}', [ContentPlanController::class, 'update'])
        ->name('contents.update');

    Route::delete('/contents/{content}', [ContentPlanController::class, 'destroy'])
        ->name('contents.destroy');


    /* ======================
       REVIEW KONTEN
    ====================== */

    // halaman review konten
    Route::get(
        '/contents/{content}/review',
        [ContentPlanController::class, 'reviewForm']
    )->name('contents.review.form');

    // submit review konten
    Route::post(
        '/contents/{content}/review',
        [ContentPlanController::class, 'review']
    )->name('contents.review');


    /* ======================
       REVIEW VIDEO
    ====================== */

    // halaman review video
    Route::get(
        '/contents/{content}/review-video',
        [ContentPlanController::class, 'reviewVideoForm']
    )->name('contents.review-video.form');

    // ❗ FIX PALING PENTING ADA DI SINI
    Route::post(
        '/contents/{content}/review-video',
        [ContentPlanController::class, 'reviewVideo'] // ✅ BUKAN review-video
    )->name('contents.review-video');

    Route::get('/recommendations', [LeaderRecommendationController::class, 'index'])
        ->name('recommendations.index');

});



// =========================
    // EDITOR MANAGEMENT
    // =========================

    Route::middleware(['auth', 'role:editor'])
    ->prefix('editor')
    ->name('editor.')
    ->group(function () {

    // LIST ASSIGNMENT
    Route::get('/contents', [EditorContentController::class, 'index'])
        ->name('contents.index');

    // FORM KERJA EDITOR
    Route::get('/contents/{content}/work', [EditorContentController::class, 'create'])
        ->name('contents.create');

    // SIMPAN HASIL KERJA
    Route::post('/contents/{content}', [EditorContentController::class, 'store'])
        ->name('contents.store');

    
    // HISTORY TASK
        Route::get('/tasks/history', [EditorTaskController::class, 'history'])
        ->name('tasks.history');

    Route::get('/tasks/report', [EditorTaskController::class, 'printReport'])
        ->name('tasks.report');

    Route::get('/tasks/{contentPlan}', [EditorTaskController::class, 'show'])
        ->name('tasks.show');


    // UPLOAD VIDEO
        // 🔥 UPLOAD VIDEO SETELAH APPROVE
    Route::get('/contents/{content}/upload-video', [ProducedVideoController::class, 'create'])
        ->name('videos.create');

    Route::post('/contents/{content}/upload-video', [ProducedVideoController::class, 'store'])
        ->name('videos.store');


// ANALYTICS
Route::get('/analytics/{content}/create', [ContentAnalyticsController::class, 'create'])
    ->name('analytics.create');

Route::post('/analytics/{content}', [ContentAnalyticsController::class, 'store'])
    ->name('analytics.store');

Route::get('/analytics/{content}', [ContentAnalyticsController::class, 'show'])
    ->name('analytics.show');

    Route::get('/analytics/export', [ContentAnalyticsController::class, 'export'])
    ->name('editor.analytics.export');

    Route::get('/analytics-export', [ContentAnalyticsController::class, 'export'])
    ->name('analytics.export');
});





//  CHAT MESSAGE


Route::middleware(['auth'])->group(function(){

Route::get('/chat',[ChatController::class,'index'])->name('chat');

Route::get('/chat/{id}',[ChatController::class,'openChat'])->name('chat.open');

Route::post('/chat/send',[ChatController::class,'send'])->name('chat.send');

Route::get('/chat/fetch/{id}',[ChatController::class,'fetchMessages']);

});


Route::get('/recommendations', [RecommendationController::class, 'index'])
    ->name('editor.recommendations.index');


});

require __DIR__.'/auth.php';
