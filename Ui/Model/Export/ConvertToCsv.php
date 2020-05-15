<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ws\Sales\Ui\Model\Export;


/**
 * Class ConvertToCsv
 */
class ConvertToCsv extends \Magento\Ui\Model\Export\ConvertToCsv
{

    /**
     * Returns CSV file
     *
     * @return array
     * @throws LocalizedException
     */
    public function getCsvFile()
    {
        $component = $this->filter->getComponent();

        $name = md5(microtime());
        $file = 'export/'. $component->getName() . $name . '.csv';

        $this->filter->prepareComponent($component);
        $this->filter->applySelectionOnTargetProvider();
        $dataProvider = $component->getContext()->getDataProvider();
        $fields = $this->metadataProvider->getFields($component);
        $options = $this->metadataProvider->getOptions();

        $this->directory->create('export');
        $stream = $this->directory->openFile($file, 'w+');
        $stream->lock();
        $wsHeaders = $this->metadataProvider->getHeaders($component);
        //Load Comment field's Key
        $commentKey = array_search('Comment', $wsHeaders);
        $stream->writeCsv($this->metadataProvider->getHeaders($component));
        $i = 1;
        $searchCriteria = $dataProvider->getSearchCriteria()
            ->setCurrentPage($i)
            ->setPageSize($this->pageSize);
        $totalCount = (int) $dataProvider->getSearchResult()->getTotalCount();

        while ($totalCount > 0) {
            $items = $dataProvider->getSearchResult()->getItems();
            foreach ($items as $item) {
                $this->metadataProvider->convertDate($item, $component->getName());
                $wsRowData = $this->metadataProvider->getRowData($item, $fields, $options);
                //Set Comment data for order
                $wsRowData[19] = $this->orderCommentData($wsRowData[0]);
                $stream->writeCsv($wsRowData);
            }
            $searchCriteria->setCurrentPage(++$i);
            $totalCount = $totalCount - $this->pageSize;
        }
        $stream->unlock();
        $stream->close();

        return [
            'type' => 'filename',
            'value' => $file,
            'rm' => true  // can delete file after use
        ];
    }


    public function orderCommentData($entity_id){
        $objectManagerHelper = \Magento\Framework\App\ObjectManager::getInstance();
        $scopePool = $objectManagerHelper->get('\Ws\Sales\Helper\Data');
        return $scopePool->getOrderComment($scopePool->getOrderEntityId($entity_id));
    }


}
