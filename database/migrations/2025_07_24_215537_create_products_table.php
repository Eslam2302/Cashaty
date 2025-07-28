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
        Schema::create('products', function (Blueprint $table) {

        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->string('image')->nullable(); // اسم ملف الصورة
        $table->string('barcode')->nullable(); // ممكن نستخدمه للباركود أو QR
        $table->integer('stock')->default(0); // الكمية المتوفرة
        $table->boolean('is_active')->default(true); // لو المنتج مفعل ولا لأ
        $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
