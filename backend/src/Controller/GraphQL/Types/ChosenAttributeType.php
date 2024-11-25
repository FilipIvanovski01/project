<?php

namespace App\Controller\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ChosenAttributeType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
        'name' => 'ChosenAttributeType',
        'fields' => [
            'id' => Type::nonNull(Type::string()),      
            'value' => Type::nonNull(Type::string()),  
            'displayValue' => Type::nonNull(Type::string()),
            ],
        ]);
    }
}
