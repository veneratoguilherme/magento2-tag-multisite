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

namespace GuilhermeVenerato\TagMultiSite\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_TAG = 'tagmultisite/';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_TAG .'general/'. $code, $storeId);
    }
}
