<?php

namespace App\Models;

use App\Enums\ForSale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Concept extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'hotel_id',
        'room_id',
        'price',
        'name',
        'open_for_sale',
    ];


    /**
     * @var array<string, ForSale>
     */
    protected $casts = [
        'open_for_sale' => ForSale::class,
    ];


    /**
     * @return BelongsTo
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class)->withDefault();
    }

    /**
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class)->withDefault();
    }


    /**
     * @return bool
     */
    public function forSaleNo(): bool
    {
        return $this->open_for_sale == ForSale::NO;
    }
}
