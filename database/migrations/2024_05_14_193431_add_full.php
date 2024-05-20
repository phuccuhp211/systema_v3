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
        Schema::create('accesses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('homet')->default(0);
            $table->bigInteger('homef')->default(0);
            $table->bigInteger('sum')->default(0);
            $table->timestamps();
        });
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->text('img');
            $table->text('tit');
            $table->text('ctn');
        });
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
            $table->text('img');
        });
        Schema::create('catalog_1', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
        });
        Schema::create('catalog_2', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
            $table->unsignedBigInteger('type');
            $table->text('img');
        });
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('noidung');
            $table->unsignedBigInteger('id_pd');
            $table->unsignedBigInteger('id_us');
            $table->date('date')->default(date('Y-m-d'));
        });
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->integer('number');
            $table->string('email',50);
            $table->text('address');
            $table->text('list_pd');
            $table->integer('price');
            $table->boolean('status')->default(0);
            $table->date('created')->default(date('Y-m-d'));
            $table->date('submited')->default(date('Y-m-d'));
            $table->integer('in_num');
            $table->string('coupon',30);
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
            $table->text('img');
            $table->text('info');
            $table->text('detail');
            $table->unsignedBigInteger('id_cata_1');
            $table->unsignedBigInteger('id_cata_2');
            $table->unsignedBigInteger('id_brand');
            $table->integer('price');
            $table->integer('sale');
            $table->date('f_date')->default(date('Y-m-d'));
            $table->date('t_date')->default(date('Y-m-d'));
            $table->integer('viewed')->default(0);
            $table->integer('saled')->default(0);
            $table->boolean('hidden')->default(1);
        });
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pd');
            $table->integer('stars');
            $table->integer('turns');
        });
        Schema::create('turn_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_us');
            $table->unsignedBigInteger('id_pd');
            $table->integer('stars');
        });
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name',40);
            $table->text('poster');
            $table->text('eb_img');
            $table->unsignedBigInteger('id_cata_1')->nullable();
            $table->unsignedBigInteger('id_cata_2')->nullable();
            $table->integer('index');
            $table->string('reference',10);
            $table->boolean('orderby');
        });
        Schema::create('uss', function (Blueprint $table) {
            $table->id();
            $table->string('account',30);
            $table->text('pass');
            $table->string('l_name',30);
            $table->string('f_name',10);
            $table->string('email',50);
            $table->text('address');
            $table->integer('number');
            $table->text('img');
            $table->boolean('role')->default(1);
            $table->boolean('lock')->default(0);
        });
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
            $table->integer('amount');
            $table->integer('remaining');
            $table->date('f_date')->default(date('Y-m-d'));
            $table->date('t_date')->default(date('Y-m-d'));
            $table->integer('discount');
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
