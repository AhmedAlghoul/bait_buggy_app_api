<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('locks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('locker_id');
            $table->unsignedBigInteger('locked_id');
            $table->timestamps();

            $table->foreign('locker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('locked_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['locker_id', 'locked_id']); // Create an index for the combination of locker_id and locked_id

            $table->unique(['locker_id', 'locked_id']); // Enforce uniqueness for the combination of locker_id and locked_id

            // Add a check constraint to ensure locker_id is not equal to locked_id
            $table->check('locker_id <> locked_id');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
