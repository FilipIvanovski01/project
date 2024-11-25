<?php

namespace App\Controller\GraphQL\Types;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class ChosenAttributeInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'ChosenAttributeInput',
            'fields' => [
                'id' => Type::nonNull(Type::string()),       
                'value' => Type::nonNull(Type::string()),  
                'displayValue' => Type::nonNull(Type::string()), 
            ],
        ]);
    }
}
