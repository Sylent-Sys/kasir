<?php

use App\Http\Controllers\PrintController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Laporan\IndexLaporan;
use App\Http\Livewire\Menu\AddMenu;
use App\Http\Livewire\Menu\EditMenu;
use App\Http\Livewire\Menu\IndexMenu;
use App\Http\Livewire\Pesanan\IndexPesanan;
use App\Http\Livewire\Transaksi\FormPembayaran;
use App\Http\Livewire\Transaksi\IndexTransaksi;
use Illuminate\Support\Facades\Auth;
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
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
    Route::get('logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('auth.login'));
    })->name('logout');
});
Route::middleware('auth')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::prefix('menu')->name('menu.')->middleware('can:admin')->group(function () {
        Route::get('/', IndexMenu::class)->name('index');
        Route::get('add', AddMenu::class)->name('add');
        Route::get('edit/{menu}', EditMenu::class)->name('edit');
    });
    Route::prefix('pesanan')->name('pesanan.')->middleware('can:admin,pengguna,waiter')->group(function () {
        Route::get('/', IndexPesanan::class)->name('index');
    });
    Route::prefix('transaksi')->name('transaksi.')->middleware('can:admin,kasir')->group(function () {
        Route::get('/', IndexTransaksi::class)->name('index');
        Route::get('pembayaran/{transaksiDetail}', FormPembayaran::class)->name('formPembayaran');
    });
    Route::prefix('laporan')->name('laporan.')->middleware('can:admin,kasir,owner')->group(function () {
        Route::get('/', IndexLaporan::class)->name('index');
    });
    Route::prefix('print')->name('print.')->middleware('can:admin,kasir,owner')->group(function () {
        Route::get('laporan/{mode}/{bulan}/{tahun}', [PrintController::class, 'printLaporan'])->name('laporan');
        Route::get('transaksi/{transaksiDetail}', [PrintController::class, 'printTransaksi'])->name('transaksi');
    });
});
