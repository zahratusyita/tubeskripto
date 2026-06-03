<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicVotingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicVotingController::class, 'index'])->name('home');
Route::post('/lookup', [PublicVotingController::class, 'lookup'])->name('voter.lookup');
Route::get('/vote', [PublicVotingController::class, 'show'])->name('vote.show');
Route::post('/vote', [PublicVotingController::class, 'submit'])->name('vote.submit');
Route::get('/success', [PublicVotingController::class, 'success'])->name('vote.success');

Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/live', [AdminController::class, 'live'])->name('live');
    Route::get('/voters/lookup', [AdminController::class, 'lookupVoter'])->name('voters.lookup');
    Route::get('/voters', [AdminController::class, 'voters'])->name('voters');
    Route::post('/voters/import', [AdminController::class, 'importVoters'])->name('voters.import');
    Route::get('/candidates', [AdminController::class, 'candidates'])->name('candidates');
    Route::post('/candidates', [AdminController::class, 'storeCandidate'])->name('candidates.store');
    Route::put('/candidates/{candidate}', [AdminController::class, 'updateCandidate'])->name('candidates.update');
    Route::delete('/candidates/{candidate}', [AdminController::class, 'deleteCandidate'])->name('candidates.delete');
    Route::patch('/election/status', [AdminController::class, 'updateElectionStatus'])->name('election.status');
    Route::post('/election/reset-demo', [AdminController::class, 'resetDemo'])->name('election.reset-demo');
    Route::get('/tally', [AdminController::class, 'tally'])->name('tally');
    Route::get('/proof', [AdminController::class, 'proof'])->name('proof');
});
