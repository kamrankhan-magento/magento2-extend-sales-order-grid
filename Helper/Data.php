<?php

namespace Ws\Sales\Helper;

use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Framework\Api\SearchCriteriaBuilder;


/**
 * Class Data
 * @package Ws\Sales\Helper
 */
class Data{

    /**
     * @var OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * Data constructor.
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository
    ) {
        $this->_orderRepository = $orderRepository;
    }


    /**
     * Get order's comment by order entity id
     * @param $entity_id
     * @return string
     */
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

    /**
     * Get order entity id by increment id.
     *
     * @param string $incrementId
     * @return OrderInterface
     * @throws NoSuchEntityException
     */
    public function getOrderEntityId($orderId){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $collection = $objectManager->create('Magento\Sales\Model\Order');
        try {
            $orderInfo = $collection->loadByIncrementId($orderId);
            return $orderInfo->getEntityId();
        }catch (\NoSuchElementException $e){
            return $e->getMessage();
        }

    }


}