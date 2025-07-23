<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrinterHistory extends Model
{
    protected $fillable = [
        'printer_id',
        'field_changed',
        'old_value',
        'new_value',
        'changed_by',
    ];

    public function printer(): BelongsTo
    {
        return $this->belongsTo(Printer::class);
    }
}
