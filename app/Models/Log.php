<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Log extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'logs';

    /**
     * @var array $guarded
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'token',
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function isValidColumn($name)
    {
        $columns = Schema::getColumnListing(Log::getTableName());
        return in_array($name, $columns);
    }
}
