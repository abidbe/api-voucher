<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'foto', 'kategori', 'status'];

    public function claims()
    {
        return $this->hasMany(VoucherClaim::class, 'id_voucher');
    }

    protected $casts = [
        'status' => 'boolean',
    ];
}
