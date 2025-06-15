<?php

declare(strict_types=1);

namespace Hibrido\ThemeCustomizer\Model;

use Hibrido\ThemeCustomizer\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    private const XML_PATH_ENABLED = 'hibrido_theme_customizer/general/enabled';
    private const XML_PATH_BUTTON_COLOR = 'hibrido_theme_customizer/button/color';

    /**
     * Config Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly StoreManagerInterface $storeManager
    ) {}

    /**
     * {@inheritdoc}
     */
    public function isEnabled(?int $storeId = null): bool
    {
        $resolvedStoreId = $storeId ?? (int) $this->storeManager->getStore()->getId();

        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $resolvedStoreId
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getButtonColor(?int $storeId = null): ?string
    {
        $resolvedStoreId = $storeId ?? (int) $this->storeManager->getStore()->getId();

        $color = $this->scopeConfig->getValue(
            self::XML_PATH_BUTTON_COLOR,
            ScopeInterface::SCOPE_STORE,
            $resolvedStoreId
        );

        return is_string($color) ? ltrim($color, '#') : null;
    }
}
