<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherClaim extends Model
{
    use HasFactory;

    protected $fillable = ['id_voucher', 'id_user', 'tanggal_claim'];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
