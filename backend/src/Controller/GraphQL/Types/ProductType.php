<?php

namespace App\Controller\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Product',
            'fields' => [
                'id' => Type::nonNull(Type::string()),
                'name' => Type::nonNull(Type::string()),
                'inStock' => Type::nonNull(Type::boolean()),
                'description' => Type::string(),
                'category' => Type::nonNull(Type::string()),
                'brand' => Type::nonNull(Type::string()),
                'price' => new PriceType(),
                'gallery' => Type::listOf(Type::string()),
                'attributes' => Type::listOf(new AttributeType()),
            ],
        ]);
    }
}
