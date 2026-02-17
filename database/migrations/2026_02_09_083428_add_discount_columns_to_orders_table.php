<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('discount_amount', 10, 2)->default(0)->after('total_amount');
            $table->string('discount_name')->nullable()->after('discount_amount');
            $table->decimal('final_amount', 10, 2)->after('discount_name');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['discount_amount', 'discount_name', 'final_amount']);
        });
    }
};

