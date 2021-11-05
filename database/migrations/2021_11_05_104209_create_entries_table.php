<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->decimal('qte',8,2);
            $table->decimal('prix_unitaire',8,2);
            $table->decimal('taux_change',8,2);
            $table->date('date_peremption')->nullable();
            $table->date('date_reception');
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('product_id');
            $table->foreignId('currency_id');
            $table->foreignId('unity_id');    
            $table->foreignId('fournisseur_id')->nullable();
            $table->string('lot_fournisseur')->nullable();
            $table->foreignId('user_id');
            $table->double('cofe')->nullable();
            $table->string('bon_commande')->nullable();
            $table->foreignId('exercice_id')->nullable();
            
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
        Schema::dropIfExists('entries');
    }
}
