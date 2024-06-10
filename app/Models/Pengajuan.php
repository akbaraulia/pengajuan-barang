<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_name',
        'quantity',
        'price',
        'status',
        'rejection_reason',
        'proof_of_transfer',
        'total_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProofOfTransferUrlAttribute()
    {
        return asset('storage/' . $this->proof_of_transfer);
    }

}