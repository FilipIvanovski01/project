<?php

namespace App\Controller\GraphQL\Types;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class ProductInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'ProductInput',
            'fields' => [
                'productId' => Type::nonNull(Type::string()), 
                'quantity' => Type::nonNull(Type::int()),      
                'choosenAttributes' => Type::listOf(new ChosenAttributeInputType()), 
            ],
        ]);
    }
}
