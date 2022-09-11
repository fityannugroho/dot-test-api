<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
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
        'name'
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
     * Get province(s) data from external source.
     * @param string $id The province Id.
     * @return array The province data(s) from external source.
     */
    public static function getFromExternal(string $id = '')
    {
        $url = config('source.external_url') . '/province';

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
     * Parse province data from external source.
     * @param array $data The province data from external source.
     * @return array The parsed province data.
     */
    public static function parseFromExternal(array $data)
    {
        // Parse single province data
        if (!is_numeric(key($data))) {
            return new Province([
                'id' => $data['province_id'],
                'name' => $data['province']
            ]);
        }

        // Parse multiple province data
        return array_map(function ($province) {
            return new Province([
                'id' => $province['province_id'],
                'name' => $province['province']
            ]);
        }, $data);
    }
}
