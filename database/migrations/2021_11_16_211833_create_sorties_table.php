<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorties', function (Blueprint $table) {
            $table->id();

            $table->decimal('qte', 10,2);
             $table->foreignId('unity_id');
            $table->foreignId('famille_id');
            $table->foreignId('user_id');
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('product_id');
            $table->date('date_consommation');
            $table->foreignId('receiver_id')->nullable();
            $table->foreignId('destination_id')->nullable();
            $table->string('observation')->nullable();
            $table->foreignId('exercice_id')->nullable();
            $table->boolean('invoice_copy')->default(false);
            $table->boolean('invoice_check')->default(0);
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
        Schema::dropIfExists('sorties');
    }
}
