<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('service_id');
            $table->integer('statut')->default(1);
            $table->boolean('lot_fournisseur')->default(0);
            $table->boolean('date_peremption')->default(0);
            $table->string('inventaire')->default('todo');
            $table->boolean('active_exercice')->default(1);
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
        Schema::dropIfExists('familles');
    }
}
