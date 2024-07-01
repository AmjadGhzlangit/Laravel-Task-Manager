<?php

use App\Enum\Task\TaskStatus;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->tinyInteger('status')->default(TaskStatus::PENDING->value); //instead of using enum().
            // cause if we want to add new value to the enum we should run ALTER TABLE
            // but like that it's flexible and extendable for updates
            // and the values should be validated in model casting
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
