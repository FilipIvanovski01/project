<?php

namespace App\Controller\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ItemType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Item',
            'fields' => [
                'displayValue' => Type::nonNull(Type::string()),
                'value' => Type::nonNull(Type::string()),
            ],
        ]);
    }
}