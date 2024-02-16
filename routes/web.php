<?php

use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Campaign\CampaignIndex;
use App\Http\Livewire\Campaign\EditCampaign;
use App\Http\Livewire\Campaign\NewCampaign;
use App\Http\Livewire\CategorySubscriber\CategoryIndex;
use App\Http\Livewire\Component\TrixEditor;
use App\Http\Livewire\Dashboard\DashboardIndex;
use App\Http\Livewire\Installer;
use App\Http\Livewire\Subscriber\ImportSubscriber;
use App\Http\Livewire\Subscriber\SubscriberIndex;
use App\Http\Livewire\Config\ConfigIndex;
use App\Http\Livewire\Template\CreateTemplate;
use App\Http\Livewire\Template\EditTemplate;
use App\Http\Livewire\Template\ManageTemplate;
use Illuminate\Support\Facades\Route;

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

Route::get('/installer', Installer::class)->name('installer')->middleware('not_installed');

Route::middleware(['installed'])->group(function () {
    Route::get('/', Login::class)->name('home');

    Route::middleware(['guest'])->group(function () {
        Route::get('/login', Login::class)->name('login');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', DashboardIndex::class)->name('dashboard');
        Route::get('/category-subscribers', CategoryIndex::class)->name('category.subscribers');
        Route::get('/subscribers', SubscriberIndex::class)->name('subscribers');
        Route::get('/import-subscribers', ImportSubscriber::class)->name('import.subscribers');

        Route::get('/campaign/manage-template', ManageTemplate::class)->name('campaign.manage.template');
        Route::get('/campaign/create-template', CreateTemplate::class)->name('campaign.template.create');
        Route::get('/campaign/edit-template/{id}', EditTemplate::class)->name('campaign.template.edit');

        Route::get('/campaign/create', NewCampaign::class)->name('campaign.create');
        Route::get('/campaign/edit/{id}', EditCampaign::class)->name('campaign.edit');
        Route::get('/campaigns', CampaignIndex::class)->name('campaigns');

        Route::get('/config', ConfigIndex::class)->name('config');
    });
});
