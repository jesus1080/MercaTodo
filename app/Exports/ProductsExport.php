<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    public function collection()
    {
        return Product::all(['id','category_id','name','price','description','image','stock','status'])
        ->prepend([
            'id','category_id','name','price','description','image','stock','status'
        ]);
    }
}
