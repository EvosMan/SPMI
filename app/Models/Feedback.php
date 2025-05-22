<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function evaluasi()
    {
        return $this->belongsTo(Evaluasi::class);
    }

    public function jadwalAudit()
    {
        return $this->belongsTo(JadwalAudit::class);
    }
}
