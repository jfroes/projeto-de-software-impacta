<?php

// Cole dentro do grupo Route::middleware('auth')->group(...) do routes/web.php
// e adicione no topo do arquivo:
// use App\Http\Controllers\OrderController;

Route::resource('orders', OrderController::class)->only(['index', 'create', 'show']);
Route::patch('orders/{order}/advance', [OrderController::class, 'advance'])->name('orders.advance');
Route::patch('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
Route::get('orders/{order}/pdf', [OrderController::class, 'pdf'])->name('orders.pdf');
