<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Toner extends Model
{
    protected $fillable = [
        'name',
        'color',
        'stock_count',
        'barcode',
        'price',
    ];

    public function printers(): BelongsToMany
    {
        return $this->belongsToMany(Printer::class)->withPivot('installed_at', 'usage_pages');
    }
}
