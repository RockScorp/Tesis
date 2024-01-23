<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table_2 extends Model
{
    use HasFactory;
    protected $table = 'table_2';
    protected $fillable = array(
                            'campo_1',
                            'table_1_id',
                            'state'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];

    public function table_1()
    {
        return $this->HasMany(Table_1::class, 'table_1_id', 'id');
    }
}
