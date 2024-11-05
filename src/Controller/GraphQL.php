<?php

namespace App\Controller;

use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use RuntimeException;
use Throwable;

class GraphQL {
    static public function handle() {
        try {
            $attributeType = new ObjectType([
                'name' => 'Attribute',
                'fields' => [
                    'value' => [
                        'type' => Type::string(),
                        'resolve' => static fn ($attribute): string => $attribute['value'],
                    ],
                ],
            ]);
            $priceType = new ObjectType([
                'name' => 'Price',
                'fields' => [
                    'amount' => [
                        'type' => Type::float(),
                        'resolve' => static fn ($price): float => $price['amount'],
                    ],
                    'currencyLabel' => [
                        'type' => Type::string(),
                        'resolve' => static fn ($price): string => $price['currencyLabel'],
                    ],
                    'currencySymbol' => [
                        'type' => Type::string(),
                        'resolve' => static fn ($price): string => $price['currencySymbol'],
                    ],
                ],
            ]);
            $queryType = new ObjectType([
                'name' => 'product',
                'fields' => [
                    'id' => [
                        'type' => Type::string(),
                        'resolve' => static fn ($id): string => $id['id'],
                    ],
                    'name' => [
                        'type' => Type::string(),
                        'resolve' => static fn ($name): string => $name['name'],
                    ],
                    'inStock' => [
                        'type' => Type::boolean(),
                        'resolve' => static fn ($inStock): bool => $inStock['inStock'],
                    ],
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => static fn ($description): string => $description['description'],
                    ],
                    'gallery' => [
                        'type' => Type::listOf(Type::string()),
                        'resolve' => static fn ($photo): array => $photo['photos'],
                    ],
                    'attributes' => [
                        'type' => Type::listOf(Type::string()), 
                        'resolve' => static fn ($attributes): array => $attributes['attributes'],
                    ],
                    'category' => [
                        'type' => Type::string(),
                        'resolve' => static fn ($category): string => $category['category']->getName(),
                    ],
                    'brand' => [
                        'type' => Type::string(),
                        'resolve' => static fn ($brand): string => $brand['brand']->getName(),
                    ],
                   'price' => [
                        'type' => $priceType,
                        'resolve' => static fn ($rootValue): array => [
                            'amount' => $rootValue['price']->getAmount(),
                            'currencyLabel' => $rootValue['price']->getCurrencyLabel(),
                            'currencySymbol' => $rootValue['price']->getCurrencySymbol(),
                        ],

                    ],
                ]
            ]);
        
            $mutationType = new ObjectType([
                'name' => 'Mutation',
                'fields' => [
                    'sum' => [
                        'type' => Type::int(),
                        'args' => [
                            'x' => ['type' => Type::int()],
                            'y' => ['type' => Type::int()],
                        ],
                        'resolve' => static fn ($calc, array $args): int => $args['x'] + $args['y'],
                    ],
                ],
            ]);
        
            // See docs on schema options:
            // https://webonyx.github.io/graphql-php/schema-definition/#configuration-options
            $schema = new Schema(
                (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
            );
        
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }
        
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;
        
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
        } catch (Throwable $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }
}