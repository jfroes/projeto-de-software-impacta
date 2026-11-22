<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete(); // quem abriu o pedido
            $table->string('status')->default('aberto');
            $table->decimal('total', 10, 2)->default(0); // denormalizado, gravado na criação
            $table->text('notes')->nullable();
            $table->timestamp('billed_at')->nullable(); // data do faturamento (base dos relatórios)
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
