<?php
/**
 * Created by PhpStorm.
 * User: doit-jung
 * Date: 20.02.2018
 * Time: 22:30
 */

namespace doitArticleRessources\Services\Decoration;


use doitArticleRessources\Services\Filter\Filter;
use Shopware\Bundle\StoreFrontBundle\Service\ProductDownloadServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct;

class DecoratedProductDownloadService implements ProductDownloadServiceInterface
{

    /**
     * @var ProductDownloadServiceInterface
     */
    private $coreService;

    /**
     * @var Filter
     */
    private $resourceFilter;

    /**
     * DecoratedProductDownloadService constructor.
     * @param ProductDownloadServiceInterface $coreService
     * @param Filter $filter
     */
    public function __construct(ProductDownloadServiceInterface $coreService, Filter $filter)
    {
        $this->coreService = $coreService;
        $this->resourceFilter = $filter;
    }

    /**
     * {@inheritdoc}
     */
    public function get(Struct\BaseProduct $product, Struct\ShopContextInterface $context)
    {
        $downloads = $this->getList([$product], $context);

        return array_shift($downloads);
    }

    /**
     * {@inheritdoc}
     */
    public function getList($products, Struct\ShopContextInterface $context)
    {
        $downloads = $this->coreService->getList($products, $context);

        foreach ($downloads as $ordernumber => $linkArray) {
            $downloads[$ordernumber] = $this->resourceFilter->filterDownloads($linkArray, $context);
        }

        return $downloads;
    }

}