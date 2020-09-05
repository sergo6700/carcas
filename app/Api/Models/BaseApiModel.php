<?php
namespace Api\Models;

use Api\Models\Scopes\PropertiesScope;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseApiModel
 * @package Api\Models
 */
abstract class BaseApiModel extends Model
{
    /**
     *
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PropertiesScope());
    }
}
