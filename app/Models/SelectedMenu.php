<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedMenu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pemasukan()
    {
        return $this->belongsTo(Pemasukan::class, 'pemasukan_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
