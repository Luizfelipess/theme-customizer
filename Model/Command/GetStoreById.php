<?php

/**
 * @copyright Copyright © 2025 Hibrido.
 */

namespace Hibrido\ThemeCustomizer\Model\Command;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;

class GetStoreById
{
    /**
     * GetStoreById Constructor
     *
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(private readonly StoreManagerInterface $storeManager) {}

    /**
     * Get Store By StoreId
     *
     * @param int $storeId
     * @return StoreInterface
     * @throws NoSuchEntityException
     */
    public function execute(int $storeId): StoreInterface
    {
        return $this->storeManager->getStore($storeId);
    }
}
