<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAudit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'kegiatan',
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'keterangan',
        'status',
        'v_kaprodi',
        'status_pelaksanaan',
        'reschedule_reason',
        'reject_reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
