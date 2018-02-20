<?php

namespace doitArticleRessources;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Models\Shop\Shop;

class doitArticleRessources extends Plugin
{
    public function install(InstallContext $context)
    {
        parent::install($context);

        $crudService = $this->container->get('shopware_attribute.crud_service');

        $colName = 'doit_subshops';
        $selectionType = 'multi_selection';
        $colConfig = [
            'entity' => Shop::class,
            'displayInBackend' => true,
            'label' => 'Sub-Shop',
            'custom' => true,
            'supportText' => 'Die Ressource wird in den ausgewählten Sub-Shops angezeigt.'
        ];

        $crudService->update('s_articles_downloads_attributes', $colName, $selectionType, $colConfig);

        $crudService->update('s_articles_information_attributes', $colName, $selectionType, $colConfig);
    }


}