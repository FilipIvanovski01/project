<?php

namespace App\Controller\GraphQL\Types;

use App\Models\Order;
use GraphQL\Type\Definition\Type;
use App\Controller\OrderController;
use GraphQL\Type\Definition\ObjectType;
use App\Controller\GraphQL\Types\OrderType;
use App\Controller\GraphQL\Types\ProductInputType;  

class MutationType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'saveOrder' => [
                    'type' => new OrderType(), 
                    'args' => [
                        'products' => Type::nonNull(Type::listOf(new ProductInputType())), 
                    ],
                    'resolve' => function ($root, $args) {

                        array_map(function($product){
                            $order = new Order($product['productId'], $product['quantity']);
                            array_map(function($attribute) use ($order){
                            $attributeTypeClass = "App\\Models\\Attribute" . str_replace(" ","",ucfirst(strtolower($attribute["id"])));
                                $order->addChoosenAttributes(new $attributeTypeClass($attribute['displayValue'], $attribute['value']));
                            }, $product["choosenAttributes"]);
                            $orderController = new OrderController();
                            $orderController->saveOrder($order);
                        }, $args['products']);
                        return [
                            'items' => $args['products'], 
                        ];
                    },
                ],
            ],
        ]);
    }
}
