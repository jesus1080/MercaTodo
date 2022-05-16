<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProductsImport implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading, WithUpserts, WithUpsertColumns
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row): Product
    {
        return new Product([
            'id' => Arr::get($row, 'id'),
            'name' => Arr::get($row, 'name'),
            'price' => Arr::get($row, 'price'),
            'image' => Arr::get($row, 'image'),
            'description' => Arr::get($row, 'description'),
            'stock' => Arr::get($row, 'stock'),
            'status' => Arr::get($row, 'status'),
            'category_id' => Arr::get($row, 'category_id'),
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function uniqueBy(): array
    {
        return ['id'];
    }

    public function upsertColumns(): array
    {
        return['name','price','status','stock','category_id','description'];
    }
}
