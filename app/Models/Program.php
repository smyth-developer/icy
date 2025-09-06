<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Program extends Model
{
    protected $fillable = ['name', 'english_name' , 'description', 'ordering', 'price'];
    
    protected $appends = ['price_formatted'];

    /**
     * Accessor + Mutator cho price
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            // Accessor: trả về giá trị gốc (số)
            get: fn ($value) => (float) $value,

            // Mutator: chuẩn hoá khi lưu (giữ nguyên decimal)
            set: fn ($value) => (float) str_replace(['.', ',', ' VNĐ'], '', $value)
        );
    }

    /**
     * Accessor cho price formatted
     */
    protected function priceFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->price, 0, ',', '.')
        );
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function tuitions()
    {
        return $this->hasMany(Tuition::class);
    }
}
