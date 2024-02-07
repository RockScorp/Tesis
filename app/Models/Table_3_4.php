<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table_3_4 extends Model
{
    use HasFactory;
    protected $table = 'table_3_4';
    protected $fillable = array(
                            'campo_1',
                            'state'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function table_7()
    {
        return $this->belongsTo(Table_7::class);
    }
}
