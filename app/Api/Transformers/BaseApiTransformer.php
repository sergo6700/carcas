<?php
namespace Api\Transformers;

use Api\Transformers\Traits\TransformCollectionTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseApiTransformer
 * @package ApiX\Transformers
 */
abstract class BaseApiTransformer
{
    use TransformCollectionTrait;

    /**
     * @param Model $item
     * @return array|mixed
     */
    public function transform($item)
    {
        $transformed = $item->toArray();

        return $transformed;
    }

    /**
     * @param $item
     * @param $key
     * @param $value
     * @return array
     */
    public function transformListItem($item, $key = 'id', $value = 'name')
    {
        $transformed = [
            'key' => $item->{$key},
            'value' => $item->{$value},
        ];

        return $transformed;
    }
}
