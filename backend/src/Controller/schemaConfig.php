<?php

use App\Controller\GraphQL\Types\AttributeType;
use Doctrine\DBAL\Query\QueryType;
use App\Controller\GraphQL\Types\ProductType;
use App\Controller\GraphQL\Types\MutationType;
use App\Controller\GraphQL\Types\OrderItemType;
use App\Controller\GraphQL\Types\ProductInputType;
use App\Controller\GraphQL\Types\ChosenAttributeType;
use App\Controller\GraphQL\Types\ChosenAttributeInputType;
use App\Controller\GraphQL\Types\ItemType;
use App\Controller\GraphQL\Types\PriceType;
use App\Controller\GraphQL\Types\QueryType as TypesQueryType;

// use App\Controller\OrderController;
// use GraphQL\Type\Definition\ObjectType;
// use GraphQL\Type\Definition\Type;

// use App\Controller\ProductController;
// use App\Models\Order;
// use GraphQL\Type\Definition\InputObjectType;

// $priceType = new ObjectType([
//     'name' => 'Price',
//     'fields' => [
//         'amount' => Type::nonNull(Type::float()),
//         'currencyLabel' => Type::nonNull(Type::string()),
//         'currencySymbol' => Type::nonNull(Type::string()),
//     ],
// ]);

// $itemType = new ObjectType([
//     'name' => 'Item',
//     'fields' => [
//         'displayValue' => Type::nonNull(Type::string()),
//         'value' => Type::nonNull(Type::string()),
//     ],
// ]);

// $attributeType = new ObjectType([
//     'name' => 'Attribute',
//     'fields' => [
//         'id' => Type::nonNull(Type::string()),
//         'items' => Type::listOf($itemType),
//     ],
// ]);

// $productType = new ObjectType([
//     'name' => 'Product',
//     'fields' => [
//         'id' => Type::nonNull(Type::string()),
//         'name' => Type::nonNull(Type::string()),
//         'inStock' => Type::nonNull(Type::boolean()),
//         'description' => Type::string(),
//         'category' => Type::nonNull(Type::string()),
//         'brand' => Type::nonNull(Type::string()),
//         'price' => $priceType,
//         'gallery' => Type::listOf(Type::string()),
//         'attributes' => Type::listOf($attributeType),
//     ],
// ]);

// $queryType = new ObjectType([
//     'name' => 'Query',
//     'fields' => [
//         'products' => [
//             'type' => Type::listOf($productType),
//             'args' => [
//                 'id' => ['type' => Type::string()],
//             ],
//             'resolve' => function ($root, $args) {
//                 $productController = new ProductController();

//                 if (isset($args['id'])) {
//                     $product = $productController->getById($args['id']);

//                     if (!$product) {
//                         throw new \Exception('Product not found');
//                     }

//                      return [
//                         [
//                             'id' => $product->getId(),
//                             'name' => $product->getName(),
//                             'description' => $product->getDescription(),
//                             'attributes' => array_map(function ($attributes) {
//                                 return [
//                                     'id' => $attributes[0]->getAttributeType(),
//                                     'items' => array_map(function ($value) {
//                                         return [
//                                             'displayValue' => $value->getDisplayValue(),
//                                             'value' => $value->getValue(),
//                                         ];
//                                     }, $attributes),
//                                 ];
//                             }, $product->getAttributes()),
//                             'price' => [
//                                 'amount' => $product->getPrice()->getAmount(),
//                                 'currencyLabel' => $product->getPrice()->getCurrencyLabel(),
//                                 'currencySymbol' => $product->getPrice()->getCurrencySymbol(),
//                             ],
//                             'gallery' => array_map(function ($photo) {
//                                 return $photo->getUrl();
//                             }, $product->getPhotos()),
//                             'category' => $product->getCategory()->getName(),
//                             'brand' => $product->getBrand()->getName(),
//                             'inStock' => $product->getInStock(),
//                         ]
//                     ];
//                 }

//                 $products = $productController->getAll();

//                 if (empty($products)) {
//                     throw new \Exception('No products found');
//                 }

//                 return array_map(function ($product) {
//                     return [
//                         'id' => $product->getId(),
//                         'name' => $product->getName(),
//                         'description' => $product->getDescription(),
//                         'attributes' => array_map(function ($attributes) {
//                             return [
//                                 'id' => $attributes[0]->getAttributeType(),
//                                 'items' => array_map(function ($value) {
//                                     return [
//                                         'displayValue' => $value->getDisplayValue(),
//                                         'value' => $value->getValue(),
//                                     ];
//                                 }, $attributes),
//                             ];
//                         }, $product->getAttributes()),
//                         'price' => [
//                             'amount' => $product->getPrice()->getAmount(),
//                             'currencyLabel' => $product->getPrice()->getCurrencyLabel(),
//                             'currencySymbol' => $product->getPrice()->getCurrencySymbol(),
//                         ],
//                         'gallery' => array_map(function ($photo) {
//                             return $photo->getUrl();
//                         }, $product->getPhotos()),
//                         'category' => $product->getCategory()->getName(),
//                         'brand' => $product->getBrand()->getName(),
//                         'inStock' => $product->getInStock(),
//                     ];
//                 }, $products);
//             },
//         ],
//     ],
// ]);


// $chosenAttributeInputType = new InputObjectType([
//     'name' => 'ChosenAttributeInput',
//     'fields' => [
//         'id' => Type::nonNull(Type::string()),       
//         'value' => Type::nonNull(Type::string()),  
//         'displayValue' => Type::nonNull(Type::string()), 
//     ],
// ]);


// $productInputType = new InputObjectType([
//     'name' => 'ProductInput',
//     'fields' => [
//         'productId' => Type::nonNull(Type::string()), 
//         'quantity' => Type::nonNull(Type::int()),      
//         'choosenAttributes' => Type::listOf($chosenAttributeInputType), 
//     ],
// ]);


// $chosenAttributeType = new ObjectType([
//     'name' => 'ChosenAttributeType',
//     'fields' => [
//         'id' => Type::nonNull(Type::string()),      
//         'value' => Type::nonNull(Type::string()),  
//         'displayValue' => Type::nonNull(Type::string()),
//     ],
// ]);


// $orderItemType = new ObjectType([
//     'name' => 'OrderItem',
//     'fields' => [
//         'productId' => Type::nonNull(Type::string()),  
//         'quantity' => Type::nonNull(Type::int()),     
//         'choosenAttributes' => Type::listOf($chosenAttributeType), 
//     ],
// ]);

// $orderType = new ObjectType([
//     'name' => 'Order',
//     'fields' => [
//         'id' => Type::nonNull(Type::int()),          
//         'items' => Type::listOf($orderItemType),     
//     ],
// ]);

// $mutationType = new ObjectType([
//     'name' => 'Mutation',
//     'fields' => [
//         'saveOrder' => [
//             'type' => $orderType, 
//             'args' => [
//                 'products' => Type::nonNull(Type::listOf($productInputType)), 
//             ],
//             'resolve' => function ($root, $args) {

//                 array_map(function($product){
//                     $order = new Order($product['productId'], $product['quantity']);
//                     array_map(function($attribute) use ($order){
//                        $attributeTypeClass = "App\\Models\\Attribute" . str_replace(" ","",ucfirst(strtolower($attribute["id"])));
//                         $order->addChoosenAttributes(new $attributeTypeClass($attribute['displayValue'], $attribute['value']));
//                     }, $product["choosenAttributes"]);
//                     print_r($order);
//                     $orderController = new OrderController();
//                     $orderController->saveOrder($order);
//                 }, $args['products']);
//                 return [
//                     'items' => $args['products'], 
//                 ];
//             },
//         ],
//     ],
// ]);



return [
    'query' => new TypesQueryType(),
    'mutation' => new MutationType(),
];