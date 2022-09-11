<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        //
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'province_id',
        'name',
        'type',
        'postal_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Get the province that owns the city.
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get city/cities data from external source.
     * @param string|null $id The city Id.
     * @return array The city data(s) from external source.
     */
    public static function getFromExternal(string $id = '')
    {
        $url = config('source.external_url') . '/city';

        return static::parseFromExternal(fetch(
            $url,
            config('source.external_key'),
            config('source.external_data_path'),
            [
                'id' => $id
            ]
        ));
    }

    /**
     * Parse city data from external source.
     * @param array $data The city data from external source.
     * @return array The parsed city data.
     */
    public static function parseFromExternal(array $data)
    {
        // Parse single city data
        if (!is_numeric(key($data))) {
            return new City([
                'id' => $data['city_id'],
                'province_id' => $data['province_id'],
                'name' => $data['city_name'],
                'type' => $data['type'],
                'postal_code' => $data['postal_code']
            ]);
        }

        // Parse multiple city data
        return array_map(function ($city) {
            return new City([
                'id' => $city['city_id'],
                'province_id' => $city['province_id'],
                'name' => $city['city_name'],
                'type' => $city['type'],
                'postal_code' => $city['postal_code']
            ]);
        }, $data);
    }

}
