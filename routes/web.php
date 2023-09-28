<?php

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
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

Route::get('/admin/languages/switcher', function (Request $request) {
    $request->validate([
        'lang' => 'required|string',
    ]);

    $user = User::find(auth()->user()->id);

    $user->lang = $request->get('lang');
    $user->save();

    Notification::make()
        ->title(trans('filament-translations::translation.notification'))
        ->icon('heroicon-o-check-circle')
        ->iconColor('success')
        ->send();

    if(config('filament-translations.redirect') === 'next'){
        return back();
    }

    return redirect()->to(config('filament-translations.redirect'));

})->middleware('web')->name('filament-translations.switcher');