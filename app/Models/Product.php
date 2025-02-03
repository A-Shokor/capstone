<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
protected $fillable =[

'name',
'quantity',
'price',
'description',
'barcode', 
'supplier_name', 
'supplier_id',  
];
public function supplier()
{
    return $this->belongsTo(Supplier::class);
}

}
