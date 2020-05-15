<?php

namespace Ws\Sales\Helper;

use \Magento\Sales\Api\OrderRepositoryInterface;

class Data{

    protected $_orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
    ) {
        $this->_orderRepository = $orderRepository;
    }

    public function getOrderComment($entity_id){
        $order = $this->_orderRepository->get($entity_id);
        $orderCommentHistory=$order->getStatusHistoryCollection();

        $comment = '';
        foreach ($orderCommentHistory as $status) {
            $comment .= strlen($comment)>0 ? ' - ' : '';
            $comment .= $status->getCreatedAt() .': '. $status->getComment();
        }

        return $comment;

    }

    public function getOrderEntityId($orderId){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('\Magento\Sales\Model\OrderRepository')->get($orderId);
        return $order->getEntityId();
    }

}