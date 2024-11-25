<?php

namespace App\Controller\GraphQL\Types;

use App\Controller\GraphQL\Types\OrderItemType;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class OrderType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Order',
            'fields' => [
                'id' => Type::nonNull(Type::int()),          
                'items' => Type::listOf(new OrderItemType()),     
            ],
        ]);
    }
}