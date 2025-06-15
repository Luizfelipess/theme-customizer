<?php

/**
 * @copyright Copyright (c) 2025 Hibrido.
 */

declare(strict_types=1);

namespace Hibrido\ThemeCustomizer\Observer;

use Hibrido\ThemeCustomizer\Api\ConfigInterface;
use Hibrido\ThemeCustomizer\Service\CssGeneratorInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Page\Config as PageConfig;

class AddButtonColorCss implements ObserverInterface
{
    /**
     * AddButtonColorCss Constructor
     *
     * @param State $appState
     * @param PageConfig $pageConfig
     * @param ConfigInterface $config
     * @param CssGeneratorInterface $cssGenerator
     */
    public function __construct(
        private readonly State $appState,
        private readonly PageConfig $pageConfig,
        private readonly ConfigInterface $config,
        private readonly CssGeneratorInterface $cssGenerator
    ) {}

    /**
     * Executes the observer logic to inject inline CSS for button color based on store configuration.
     *
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(Observer $observer): void
    {
        if ($this->appState->getAreaCode() !== Area::AREA_FRONTEND) {
            return;
        }

        if (!$this->config->isEnabled()) {
            return;
        }

        $color = $this->config->getButtonColor();

        if (!$color) {
            return;
        }

        $css = $this->cssGenerator->generate(['button_color' => $color]);

        if (!$css) {
            return;
        }

        $this->pageConfig->addRemotePageAsset(
            'data:text/css;base64,' . base64_encode($css),
            'css',
            ['attributes' => ['type' => 'text/css']]
        );
    }
}
