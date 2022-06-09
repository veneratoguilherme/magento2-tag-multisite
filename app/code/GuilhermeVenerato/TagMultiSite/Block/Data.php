<?php

/**
 * Tag Multi Site
 *
 * GuilhermeVenerato_TagMultiSite
 *
 * @category  GuilhermeVenerato
 * @package   GuilhermeVenerato_TagMultiSite
 * @author    Guilherme Venerato <guilhermevenerato@hotmail.com>
 * @copyright Copyright (c) 2022 Guilherme Venerato
 * @license https://opensource.org/licenses/OSL-3.0.php Open Software License 3.0
 */

declare(strict_types=1);

namespace GuilhermeVenerato\TagMultiSite\Block;

use GuilhermeVenerato\TagMultiSite\Helper\Data as HelperTagMultiSite;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data extends Template
{
    /**
     * @var Context
     */
    private Context $context;

    /**
     * @var HelperTagMultiSite
     */
    private HelperTagMultiSite $helperTagMultiSite;

    /**
     * @var Http
     */
    private Http $http;

    /**
     * @var Page
     */
    private Page $page;

    /**
     * var StoreManagerInterface
     */
    private StoreManagerInterface $store;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var PageRepositoryInterface
     */
    private PageRepositoryInterface $pageRepositoryInterface;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var urlInterface
     */
    private urlInterface $urlInterface;

    /**
     * @param Context $context
     * @param HelperTagMultiSite $helperTagMultiSite
     * @param Http $http
     * @param Page $page
     * @param StoreManagerInterface $store
     * @param ScopeConfigInterface $scopeConfig
     * @param PageRepositoryInterface $pageRepositoryInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param UrlInterface $urlInterface
     */
    public function __construct(
        Context $context,
        HelperTagMultiSite $helperTagMultiSite,
        Http $http,
        Page $page,
        StoreManagerInterface $store,
        ScopeConfigInterface $scopeConfig,
        PageRepositoryInterface $pageRepositoryInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        UrlInterface $urlInterface
    ) {
        parent::__construct($context);
        $this->helperTagMultiSite = $helperTagMultiSite;
        $this->http = $http;
        $this->page = $page;
        $this->store = $store;
        $this->scopeConfig = $scopeConfig;
        $this->pageRepositoryInterface = $pageRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->urlInterface = $urlInterface;
    }

    public function getTagMultiSite()
    {
        $isEnable = $this->helperTagMultiSite->getGeneralConfig('enable');
        $tag = '';
        if ($isEnable) {
            $checkModule = $this->http->getModuleName();
            if ($checkModule == 'cms') {
                $searchCriteria = $searchCriteria = $this->searchCriteriaBuilder->create();
                $pages = $this->pageRepositoryInterface->getList($searchCriteria)->getItems();
                foreach ($pages as $page) {
                    if ($page->getIdentifier() == $this->page->getIdentifier()) {
                        foreach ($page->getStores() as $store) {
                            $storeLanguage = str_replace('_','-',$this->getStoreLanguage($store));
                            $currentUrl = $this->urlInterface->getBaseUrl();
                            $tag .= '<link rel="alternate" hreflang="' . $storeLanguage . '" href="' . $currentUrl . $this->page->getIdentifier() .'" />';
                        }
                    }
                }
            }
        }
        return $tag;
    }

    private function getStoreLanguage($viewId){

        return $this->scopeConfig->getValue('general/locale/code',
            ScopeInterface::SCOPE_STORE,
            $viewId
        );


    }
}
