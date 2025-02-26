<?php

namespace Agenciafmd\Leads\Models;

use Agenciafmd\Admix\Traits\WithScopes;
use Agenciafmd\Leads\Database\Factories\LeadFactory;
use Agenciafmd\Leads\Observers\LeadObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

#[ObservedBy([LeadObserver::class])]
class Lead extends Model implements AuditableContract
{
    use Auditable, HasFactory, Prunable, SoftDeletes, WithScopes;

    protected array $defaultSort = [
        'is_active' => 'desc',
        'created_at' => 'desc',
        'name' => 'asc',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function prunable(): Builder
    {
        return self::where('deleted_at', '<=', now()->subYear());
    }

    protected static function newFactory(): LeadFactory
    {
        if (class_exists(\Database\Factories\LeadFactory::class)) {
            return \Database\Factories\LeadFactory::new();
        }

        return LeadFactory::new();
    }
}
