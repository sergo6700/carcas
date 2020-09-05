<?php

namespace Api\Transformers;

use Api\Models\Client;
use Illuminate\Support\Arr;

/**
 * Class ClientTransformer
 * @package Api\Transformers
 */
class ClientTransformer extends BaseApiTransformer
{
    /**
     * @param Client $item
     * @return array|mixed
     * @throws \Exception
     */
    public function transform($item)
    {
        $result = parent::transform($item);

        $clientTypes = get_class_constants(\ConstClientType::class, true);
        $result['type_name'] = Arr::get($clientTypes, $item->type);

        return $result;
    }
}
