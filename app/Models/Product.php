<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
        'stock',
        'status',
        'category_id',
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function invoice(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class);
    }
    public function getImageAttribute(): string
    {
        $path = explode("public/", $this->attributes['image']);
        return url('/'.$path[1]);
    }

    public function getImageName(): string
    {
        $path = explode("/", $this->attributes['image']);
        return $path[3];
    }

    public function scopeName(Builder $query, ?string $name): Builder
    {
        if (null !== $name) {
            return $this->searchByField($query, 'name', "%$name%", 'like');
        }

        return $query;
    }
    public function scopePriceMin(Builder $query, ?string $price): Builder
    {
        if (null !== $price) {
            return $query->where('price', '<', $price);
        }

        return $query;
    }
    public function scopePriceMax(Builder $query, ?string $price): Builder
    {
        if (null !== $price) {
            return $query->where('price', '>', $price);
        }

        return $query;
    }
    public function scopeCategory($query, $category_id): Builder
    {
        return $query->when($category_id, function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        });
    }
    private function searchByField(Builder $query, string $field, string $value, string $operator = null): Builder
    {
        return $query->where($field, $operator, $value);
    }
}
