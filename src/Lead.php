<?php

namespace Agenciafmd\Leads;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Lead extends Model implements AuditableContract, Searchable
{
    use SoftDeletes, Auditable;

    protected $guarded = [
        //
    ];

    public $searchableType;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->searchableType = config('admix-leads.name');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            "{$this->name} ({$this->email})",
            route('admix.leads.edit', $this->id)
        );
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active', 1);
    }

    public function scopeSort($query)
    {
        $sorts = default_sort(config('admix-leads.default_sort'));

        foreach ($sorts as $sort) {
            $query->orderBy($sort['field'], $sort['direction']);
        }
    }
}
