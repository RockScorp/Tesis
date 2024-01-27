<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table_7 extends Model
{
    use HasFactory;
    protected $table = 'table_7';
    protected $fillable = array(
                            'campo_1',
                            'campo_2',
                            'campo_3',
                            'table_4_id',
                            'campo_4',
                            'state'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function table_4()
    {
        return $this->belongsTo(Table_3_4::class, 'table_3_id', 'id')->where('state','A');
    }
}
