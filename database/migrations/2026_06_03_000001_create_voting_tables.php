<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('village_name');
            $table->string('status')->default('open');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });

        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('identity_number')->unique();
            $table->string('full_name');
            $table->string('region');
            $table->boolean('has_voted')->default(false);
            $table->timestamp('voted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('ballot_number');
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('vision');
            $table->text('mission');
            $table->timestamps();
            $table->unique(['election_id', 'ballot_number']);
        });

        Schema::create('ballots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->string('anonymous_token_hash')->unique();
            $table->longText('encrypted_vote');
            $table->string('integrity_hash');
            $table->timestamp('cast_at');
            $table->timestamps();
        });

        Schema::create('rsa_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->longText('public_key');
            $table->longText('private_key_encrypted');
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->text('detail')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('rsa_keys');
        Schema::dropIfExists('ballots');
        Schema::dropIfExists('candidates');
        Schema::dropIfExists('voters');
        Schema::dropIfExists('elections');
    }
};
