<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tuition extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'receipt_number',
        'program_id',
        'season_id',
        'price',
        'status',
        'payment_method',
        'bank_id',
        'note',
    ];

    protected $appends = ['price_formatted', 'created_at_formatted'];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (float) $value,
            set: fn ($value) => (float) str_replace(['.', ',', ' VNĐ'], '', $value)
        );
    }

    protected function priceFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->price, 0, ',', '.')
        );
    }

    protected function createdAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at ? $this->created_at->format('d/m/Y H:i') : null
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
