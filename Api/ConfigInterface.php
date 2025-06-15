<?php

declare(strict_types=1);

namespace Hibrido\ThemeCustomizer\Api;

interface ConfigInterface
{
    /**
     * Check if the module is enabled.
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled(?int $storeId = null): bool;

    /**
     * Get the configured primary button color.
     *
     * @param int|null $storeId
     * @return string|null
     */
    public function getButtonColor(?int $storeId = null): ?string;
}
