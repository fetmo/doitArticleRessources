<?php
/**
 * Created by PhpStorm.
 * User: doit-jung
 * Date: 20.02.2018
 * Time: 22:29
 */

namespace doitArticleRessources\Services\Decoration;


use doitArticleRessources\Services\Filter\Filter;
use Shopware\Bundle\StoreFrontBundle\Service\ProductLinkServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct;

class DecoratedProductLinkService implements ProductLinkServiceInterface
{

    /**
     * @var ProductLinkServiceInterface
     */
    private $coreService;

    /**
     * @var Filter
     */
    private $resourceFilter;

    /**
     * DecoratedProductLinkService constructor.
     * @param ProductLinkServiceInterface $coreService
     * @param Filter $filter
     */
    public function __construct(ProductLinkServiceInterface$coreService, Filter $filter)
    {
        $this->coreService = $coreService;
        $this->resourceFilter = $filter;
    }

    /**
     * {@inheritdoc}
     */
    public function get(Struct\BaseProduct $product, Struct\ShopContextInterface $context)
    {
        $links = $this->getList([$product], $context);

        return array_shift($links);
    }

    /**
     * {@inheritdoc}
     */
    public function getList($products, Struct\ShopContextInterface $context)
    {
        $links = $this->coreService->getList($products, $context);

        foreach ($links as $ordernumber => $linkArray) {
            $links[$ordernumber] = $this->resourceFilter->filterLinks($linkArray, $context);
        }

        return $links;
    }

}