<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailEvaluasi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function evaluasi()
    {
        return $this->belongsTo(Evaluasi::class);
    }

    public function hasilEvaluasi()
    {
        return $this->hasOne(HasilEvaluasi::class);
    }
}
