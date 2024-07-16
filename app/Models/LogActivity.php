<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTypeColor()
    {
        // Logika untuk menentukan warna berdasarkan tipe aktivitas
        if ($this->activity === 'Logged In') {
            return 'text-success';
        } elseif ($this->activity === 'Logged Out') {
            return 'text-danger';
        }

        // Jika tipe aktivitas tidak sesuai dengan kondisi di atas, Anda dapat memberikan warna default atau tidak memberikan kelas warna
        return '';
    }
}
