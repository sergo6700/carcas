<?php

namespace Api\Transformers;

/**
 * Class DerivationRuleTransformer
 * @package Api\Transformers
 */
class DerivationRuleTransformer extends BaseApiTransformer
{
    /**
     * @param DerivationRule $item
     * @return array|mixed
     */
    public function transform($item)
    {
        $result = parent::transform($item);

        if ($item->amount_status) {
            $result['amount_status_name'] = trans('derivations.amount_status.'.$item->amount_status);
        }

        return $result;
    }

}
