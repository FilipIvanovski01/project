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
            $priceType = new ObjectType([
                'name' => 'Price',
                'fields' => [
                    'amount' => Type::nonNull(Type::float()),
                    'currencyLabel' => Type::nonNull(Type::string()),
                    'currencySymbol' => Type::nonNull(Type::string()),
                ],
            ]);
            $photoType = new ObjectType([
                'name' => 'Photo',
                'fields' => [
                    'imageUrl' => Type::nonNull(Type::string()),
                ],
            ]);
            $attributeType = new ObjectType([
                'name' => 'Attribute',
                'fields' => [
                    'displayValue' => Type::nonNull(Type::string()),
                    'value' => Type::nonNull(Type::string()),
                ],
            ]);
            $categoryType = new ObjectType([
                'name' => 'Category',
                'fields' => [
                    'name' => Type::nonNull(Type::string()),
                ],
            ]);
            $brandType = new ObjectType([
                'name' => 'Brand',
                'fields' => [
                    'name' => Type::nonNull(Type::string()),
                ],
            ]);
            $productType = new ObjectType([
                'name' => 'Product',
                'fields' => [
                    'id' => Type::nonNull(Type::int()),
                    'name' => Type::nonNull(Type::string()),
                    'inStock' => Type::nonNull(Type::boolean()),
                    'description' => Type::string(),
                    'category' => $categoryType,
                    'brand' => $brandType,
                    'price' => $priceType,
                    'photos' => Type::listOf($photoType),
                    'attributes' => Type::listOf($attributeType),
                ],
            ]);
            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'products' => [
                        'type' => Type::listOf($productType),
                        'resolve' => function () {
                            $productController = new ProductController();
                            return $productController->getAll();
                        },
                    ],
                    'product' => [
                        'type' => $productType,
                        'args' => [
                            'id' => Type::nonNull(Type::int()),
                        ],
                        'resolve' => function ($root, $args) {
                            $productController = new ProductController();
                            $allProducts = $productController->getAll();
                            foreach ($allProducts as $product) {
                                if ($product->getId() === $args['id']) {
                                    return $product;
                                }
                            }
                            return null;
                        },
                    ],
                ],
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