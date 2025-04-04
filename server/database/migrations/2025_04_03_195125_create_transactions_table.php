<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal("amount", 15, 2);
            $table->string("order_id");
            $table->string("timestamp");
            $table->enum("type", ["deposite", "withdraw"]);
            $table->enum("status", [1, 2]);
            $table->string("user_fullname");
            $table->string("gateway_transaction_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
