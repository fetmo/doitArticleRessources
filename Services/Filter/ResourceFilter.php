<?php

namespace doitArticleRessources\Services\Filter;

use Shopware\Bundle\StoreFrontBundle\Struct\Extendable;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

class ResourceFilter implements Filter
{

    /**
     * @param array $downloads
     * @param ShopContextInterface $context
     * @return array
     */
    public function filterDownloads(array $downloads, ShopContextInterface $context)
    {
        $shopID = $context->getShop()->getId();

        return $this->filter($downloads, $shopID);
    }

    /**
     * @param array $links
     * @param ShopContextInterface $context
     * @return array
     */
    public function filterLinks(array $links, ShopContextInterface $context)
    {
        $shopID = $context->getShop()->getId();

        return $this->filter($links, $shopID);
    }

    /**
     * @param array $items
     * @param $shopID
     * @return array
     */
    private function filter(array $items, $shopID)
    {
        foreach ($items as $index => $item) {
            $hide = $this->shouldHide($shopID, $item);

            if($hide){
                unset($items[$index]);
            }
        }

        return $items;
    }

    /**
     * @param $shopID
     * @param Extendable $item
     * @return bool
     */
    private function shouldHide($shopID, Extendable $item)
    {
        $shops = $item->getAttribute('core')->get('doit_subshops');
        $hide = $shops !== null;

        if($hide){
            $shops = array_filter(explode('|', $shops));

            $hide = !in_array($shopID, $shops, false);
        }

        return $hide;
    }

}