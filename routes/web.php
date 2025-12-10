<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\DashboardController;
use \App\Http\Controllers\CampaignController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/login', [AuthController::class, 'loginWeb'])->name('login.submit');

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/campaigns/{id}/status', [CampaignController::class, 'updateStatus'])->name('campaigns.updateStatus');

Route::delete('/campaigns/{id}', [CampaignController::class, 'deleteCampaign'])->name('campaigns.destroy');

Route::post('/logout', [AuthController::class, 'logoutWeb'])->name('logout');

Route::get('campaigns/{id}/export/csv', [CampaignController::class, 'exportCsv'])
    ->name('campaigns.export.csv');

Route::get('campaigns/{id}/export/pdf', [CampaignController::class, 'exportPdf'])
    ->name('campaigns.export.pdf');

