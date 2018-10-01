<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('brand_id')->unsigned()->nullable()->index();
            $table->string('title');
            $table->string('slug');
            $table->string('code')->unique();
            $table->string('short')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price');
            $table->decimal('price_outlet')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('stock')->default(false);
            $table->boolean('featured')->default(false);
            $table->boolean('publish')->default(false);
            $table->timestamp('publish_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('brand_id')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
