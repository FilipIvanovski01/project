<?php

namespace App\Controller\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderItemType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'OrderItem',
            'fields' => [
                'productId' => Type::nonNull(Type::string()),  
                'quantity' => Type::nonNull(Type::int()),     
                'choosenAttributes' => Type::listOf(new ChosenAttributeType()), 
            ],
        ]);
    }
}
