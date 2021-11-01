<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->string('sage')->nullable();
            $table->foreignId('famille_id');
            $table->foreignId('unite_id');
            $table->boolean('lot_fournisseur')->default(0);
            $table->boolean('date_peremption')->default(0);
            $table->decimal('prix_moyen',8,3)->nullable();
            $table->integer('statut')->default(1);
            $table->softDeletes();
            $table->timestamps();
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
