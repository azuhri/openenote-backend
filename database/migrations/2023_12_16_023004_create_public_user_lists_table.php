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
        Schema::create('public_user_lists', function (Blueprint $table) {
            $table->id();
            $table->string("note_id")->index();
            $table->string("user_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("note_id")->references("id")->on("notes");
            $table->timestamps();
        });

        // Schema::table('notes', function (Blueprint $table) {
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_user_lists');
    }
};
