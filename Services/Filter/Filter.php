<?php

namespace doitArticleRessources\Services\Filter;


use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

interface Filter
{

    public function filterDownloads(array $downloads, ShopContextInterface $context);

    public function filterLinks(array $links, ShopContextInterface $context);

}