<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table_1 extends Model
{
    use HasFactory;
    protected $table = 'table_1';
    protected $fillable = array(
                            'campo_1',
                            'campo_2',
                            'campo_3',
                            // 'table_2_id',
                            'state'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function table_2()
    {
    return $this->HasMany(Table_2::class)->where('state','A');
    }
}
