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
        'total_price',
        'approved_by_manager',
        'approved_by_finance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProofOfTransferUrlAttribute()
    {
        return asset('storage/' . $this->proof_of_transfer);
    }
    public function approvedByManager()
    {
        return $this->belongsTo(User::class, 'approved_by_manager');
    }

    public function approvedByFinance()
    {
        return $this->belongsTo(User::class, 'approved_by_finance');
    }

}