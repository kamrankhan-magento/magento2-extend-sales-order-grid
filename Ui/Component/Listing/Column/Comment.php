<?php
namespace Ws\Sales\Ui\Component\Listing\Column;

use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\Api\SearchCriteriaBuilder;
use \Ws\Sales\Helper\Data;

class Comment extends Column
{
    protected $_orderRepository;
    protected $_searchCriteria;

    protected $_orderData;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $criteria,
        Data $orderData,
        array $components = [],
        array $data = []
    )
    {
        $this->_orderRepository = $orderRepository;
        $this->_searchCriteria  = $criteria;
        $this->_orderData = $orderData;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

                //$order  = $this->_orderRepository->get($item["entity_id"]);
                //$status = $order->getStatusHistoryCollection();
                /*$comment = '';
                foreach ($order->getStatusHistoryCollection() as $status) {
                    $comment .= strlen($comment)>0 ? ' - ' : '';
                    $comment .= $status->getCreatedAt() .': '. $status->getComment();
                }*/

                $comment = $this->_orderData->getOrderComment($item["entity_id"]);
                // $this->getData('name') returns the name of the column so in this case it would return comment
                $item[$this->getData('name')] = $comment;
            }
        }

        return $dataSource;
    }
}