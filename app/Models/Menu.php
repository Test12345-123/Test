<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $fillable = [
        'nama_menu',
        'harga',
        'image',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'detail_orders', 'id_menu', 'id_order')
            ->withPivot('qty');
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class);
    }
}
