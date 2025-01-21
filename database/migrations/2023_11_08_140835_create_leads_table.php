<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_active')
                ->unsigned()
                ->index()
                ->default(1);
            $table->string('source')
                ->nullable()
                ->default(null);
            $table->string('name')
                ->nullable();
            $table->string('email')
                ->nullable();
            $table->string('phone')
                ->nullable();
            $table->text('description')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
