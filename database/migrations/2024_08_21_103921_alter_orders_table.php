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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_status',['paid on cod','paid with Stripe Card','not paid','paid with PayPal','paid with BraintreeCard'])->after('grand_total')->default('not paid');
            $table->enum('status',['pending','shipped','out for delivery','delivered','cancelled','refended'])->after('payment_status')->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // $table->dropColumn('payment_status');
            $table->dropColumn('status');
        });
    }
    
};
