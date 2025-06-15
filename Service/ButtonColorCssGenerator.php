<?php

/**
 * @copyright Copyright (c) 2025 Hibrido.
 */

declare(strict_types=1);

namespace Hibrido\ThemeCustomizer\Service;

class ButtonColorCssGenerator implements CssGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate(array $params): string
    {
        $hexColor = $params['button_color'] ?? '';

        if (!preg_match('/^[0-9a-f]{6}$/i', $hexColor)) {
            return '';
        }

        return <<<CSS
            button.primary,
            a.primary {
                background-color: #{$hexColor} !important;
                border-color: #{$hexColor} !important;
                color: #fff !important;
            }

            .primary:hover,
            .primary:focus {
                filter: brightness(90%) !important;
                outline: none !important;
            }
        CSS;
    }
}
