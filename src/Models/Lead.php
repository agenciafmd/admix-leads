<?php

namespace Agenciafmd\Leads\Models;

use Agenciafmd\Admix\Traits\WithScopes;
use Agenciafmd\Leads\Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Lead extends Model implements AuditableContract
{
    use Auditable, HasFactory, SoftDeletes, WithScopes;

    protected $guarded = [
        //
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected array $defaultSort = [
        'is_active' => 'desc',
        'created_at' => 'desc',
        'name' => 'asc',
    ];

    protected static function newFactory(): LeadFactory
    {
        if (class_exists(\Database\Factories\LeadFactory::class)) {
            return \Database\Factories\LeadFactory::new();
        }

        return LeadFactory::new();
    }
}
