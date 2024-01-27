<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table_5_6 extends Model
{
    use HasFactory;
    protected $table = 'table_5_6';
    protected $fillable = array(
                            'campo_1',
                            'campo_2',
                            'table_3_id',
                            'state'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function table_3()
    {
        return $this->belongsTo(Table_3_4::class, 'table_3_id', 'id')->where('state','A');
    }
}
