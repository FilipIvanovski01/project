<?php

namespace App\Controller\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PriceType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Price',
            'fields' => [
                'amount' => Type::nonNull(Type::float()),
                'currencyLabel' => Type::nonNull(Type::string()),
                'currencySymbol' => Type::nonNull(Type::string()),
            ],
        ]);
    }
}
