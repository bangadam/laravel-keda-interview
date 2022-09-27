<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'reason',
        'customer_id',
        'staff_id',
    ];

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
