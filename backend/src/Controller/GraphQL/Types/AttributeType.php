<?php
namespace App\Controller\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Attribute',
            'fields' => [
                'id' => Type::nonNull(Type::string()),
                'items' => Type::listOf(new ItemType()),
            ],
        ]);
    }
}
