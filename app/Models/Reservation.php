<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id', 'table_id', 'guests', 'reservation_time', 'status'];

    public function table() {
        return $this->belongsTo(Table::class);
    }
}
