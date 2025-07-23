<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Printer extends Model
{
    protected $fillable = [
        'name',
        'ip_address',
        'printer_type_id',
        'serial_number',
        'location',
        'phone_extension',
        'notes',
    ];

    public function printerType(): BelongsTo
    {
        return $this->belongsTo(PrinterType::class);
    }

    public function toners(): BelongsToMany
    {
        return $this->belongsToMany(Toner::class)->withPivot('installed_at', 'usage_pages');
    }
}
