<?php

use App\Enums\OrderStatus;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\UsersController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'force.password.change'])->group(function () {
   Route::get('/', function () {
       $stats = [
           'orders_total' => Order::count(),
           'orders_open' => Order::where('status', OrderStatus::ABERTO)->count(),
           'low_stock_products' => Product::where('stock_quantity', '<=', 5)->count(),
       ];

       return view('home.index', compact('stats'));
   })->name('home');

   Route::resource('users', UsersController::class)->middleware('role:admin');

   Route::get('/profile', [ProfilesController::class, 'edit'])->name('profile.edit');
   Route::put('/profile', [ProfilesController::class, 'update'])->name('profile.update');

   Route::resource('products', ProductController::class);
   Route::resource('clients', ClientController::class);

   Route::resource('orders', OrderController::class)->only(['index', 'create', 'show']);
   Route::patch('orders/{order}/advance', [OrderController::class, 'advance'])->name('orders.advance');
   Route::patch('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
   Route::get('orders/{order}/pdf', [OrderController::class, 'pdf'])->name('orders.pdf');
});

Route::middleware('auth')->group(function () {
   Route::get('/password-change', [AuthController::class, 'changePassword'])->name('new-user');
   Route::post('/password-change', [AuthController::class, 'updatePassword'])->name('password-change');
   Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
   Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
   Route::get('/login', function () {
       return view('auth.login');
   })->name('login');
   Route::get('/new-user-confirmation/{token}', [AuthController::class, 'newUserConfirmation'])->name('users.confirm');
});
