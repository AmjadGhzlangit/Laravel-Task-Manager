<?php

namespace App\Models;

use App\Enum\Task\TaskStatus;
use App\Observers\TaskObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy(TaskObserver::class)]
class Task extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

    protected static function boot()
    {
        Task::addGlobalScope('taskOwner', function (Builder $query) {
            return $query->where('user_id', auth()->id());
        });
        parent::boot();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
