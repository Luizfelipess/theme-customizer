<?php

/**
 * @copyright Copyright © 2025 Hibrido.
 */

namespace Hibrido\ThemeCustomizer\Model\Validator;

class HexColorValidator
{
    /**
     * Valid HexColor
     *
     * @param string $color
     * @return bool
     */
    public function isValid(string $color): bool
    {
        return (bool) preg_match('/^[a-fA-F0-9]{6}$/', $color);
    }
}
