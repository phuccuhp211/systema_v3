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
        Schema::table('catalog_2', function(Blueprint $table) {
            $table->foreign('type')->references('id')->on('catalog_1')->onDelete('cascade');
        });
        Schema::table('products', function(Blueprint $table) {
            $table->foreign('id_cata_1')->references('id')->on('catalog_1')->onDelete('cascade');
            $table->foreign('id_cata_2')->references('id')->on('catalog_2')->onDelete('cascade');
            $table->foreign('id_brand')->references('id')->on('brands')->onDelete('cascade');
        });
        Schema::table('ratings', function(Blueprint $table) {
            $table->foreign('id_pd')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('turn_ratings', function(Blueprint $table) {
            $table->foreign('id_us')->references('id')->on('uss')->onDelete('cascade');
            $table->foreign('id_pd')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('sections', function(Blueprint $table) {
            $table->foreign('id_cata_1')->references('id')->on('catalog_1')->onDelete('cascade');
            $table->foreign('id_cata_2')->references('id')->on('catalog_2')->onDelete('cascade');
        });
        Schema::table('comments', function(Blueprint $table) {
            $table->foreign('id_us')->references('id')->on('uss')->onDelete('cascade');
            $table->foreign('id_pd')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
