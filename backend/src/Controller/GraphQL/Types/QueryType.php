<?php
namespace App\Controller\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Controller\ProductController;
use App\Models\Product;

class QueryType extends ObjectType
{
    private ProductController $productController;

    public function __construct()
    {
        $this->productController = new ProductController();

        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'products' => [
                    'type' => Type::listOf(new ProductType()),
                    'args' => [
                        'id' => ['type' => Type::string()],
                    ],
                    'resolve' => function ($root, $args) {
                        $productController = new ProductController();
                        if (isset($args['id'])) {
                            $product = $productController->getById($args['id']);
                            if (!$product) {
                                throw new \Exception('Product not found');
                            }
                            return [
                                [
                                    'id' => $product->getId(),
                                    'name' => $product->getName(),
                                    'description' => $product->getDescription(),
                                    'attributes' => array_map(function ($attributes) {
                                        return [
                                            'id' => $attributes[0]->getAttributeType(),
                                            'items' => array_map(function ($value) {
                                                return [
                                                    'displayValue' => $value->getDisplayValue(),
                                                    'value' => $value->getValue(),
                                                ];
                                            }, $attributes),
                                        ];
                                    }, $product->getAttributes()),
                                    'price' => [
                                        'amount' => $product->getPrice()->getAmount(),
                                        'currencyLabel' => $product->getPrice()->getCurrencyLabel(),
                                        'currencySymbol' => $product->getPrice()->getCurrencySymbol(),
                                    ],
                                    'gallery' => array_map(function ($photo) {
                                        return $photo->getUrl();
                                    }, $product->getPhotos()),
                                    'category' => $product->getCategory()->getName(),
                                    'brand' => $product->getBrand()->getName(),
                                    'inStock' => $product->getInStock(),
                                ]
                            ];
                        }

                        $products = $productController->getAll();

                        if (empty($products)) {
                            throw new \Exception('No products found');
                        }

                        return array_map(function ($product) {
                            return [
                                'id' => $product->getId(),
                                'name' => $product->getName(),
                                'description' => $product->getDescription(),
                                'attributes' => array_map(function ($attributes) {
                                    return [
                                        'id' => $attributes[0]->getAttributeType(),
                                        'items' => array_map(function ($value) {
                                            return [
                                                'displayValue' => $value->getDisplayValue(),
                                                'value' => $value->getValue(),
                                            ];
                                        }, $attributes),
                                    ];
                                }, $product->getAttributes()),
                                'price' => [
                                    'amount' => $product->getPrice()->getAmount(),
                                    'currencyLabel' => $product->getPrice()->getCurrencyLabel(),
                                    'currencySymbol' => $product->getPrice()->getCurrencySymbol(),
                                ],
                                'gallery' => array_map(function ($photo) {
                                    return $photo->getUrl();
                                }, $product->getPhotos()),
                                'category' => $product->getCategory()->getName(),
                                'brand' => $product->getBrand()->getName(),
                                'inStock' => $product->getInStock(),
                            ];
                        }, $products);
                    },
                ],
            ],
        ]);
    }
}
