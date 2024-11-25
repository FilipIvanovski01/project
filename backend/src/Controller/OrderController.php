<?php
namespace App\Controller;

use App\Config\Database;
use App\Models\Order;

class OrderController
{
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

   public function saveOrder(Order $order)
{
    try {
        $this->connection->beginTransaction();
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->insert('Orders')
            ->values([
                'product_id' => ':product_id',
                'quantity' => ':quantity',
            ])
            ->setParameters([
                'product_id' => $order->getProductId(),
                'quantity' => $order->getQuantity(),
            ]);
        $queryBuilder->executeStatement();
        $orderId = $this->connection->lastInsertId();
        error_log("Order inserted with ID: $orderId");
        if (!empty($order->getChoosenAttributes())) {
            $queryBuilder = $this->connection->createQueryBuilder();
            $queryBuilder
                ->insert('ChoosenAttributesOrders')
                ->values([
                    'order_id' => ':order_id',
                    'attribute_id' => ':attribute_id',
                ]);
            $attributeController = new AttributeController();
            foreach ($order->getChoosenAttributes() as $attribute) {
                $attributeId = $attributeController->getAttributeId($attribute->getAttributeType(), $attribute->getValue(), $attribute->getDisplayValue());
                error_log("Inserting attribute with ID: $attributeId for Order ID: $orderId");
                $queryBuilder->setParameters([
                    'order_id' => $orderId,
                    'attribute_id' => $attributeId,
                ]);
                $queryBuilder->executeStatement();
            }
        }
        $this->connection->commit();
        return $orderId;

    } catch (\Exception $e) {
        error_log("Error occurred: " . $e->getMessage());
        $this->connection->rollBack();
    }
}

}
