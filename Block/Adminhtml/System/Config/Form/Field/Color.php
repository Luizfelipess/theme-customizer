<?php

/**
 * @copyright Copyright (c) 2025 Hibrido.
 */

declare(strict_types=1);

namespace Hibrido\ThemeCustomizer\Block\Adminhtml\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Color extends Field
{
    /**
     * Render the color input with color picker and background.
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $html = $element->getElementHtml();
        $value = (string) $element->getData('value');

        if ($value && !str_starts_with($value, '#')) {
            $value = '#' . $value;
        }

        $html .= '<script type="text/javascript">
            require(["jquery", "jquery/colorpicker/js/colorpicker"], function ($) {
                $(document).ready(function () {
                    var thisElement = $("#' . $element->getHtmlId() . '");
                    thisElement.css("backgroundColor", "' . $value . '");
                    thisElement.ColorPicker({
                        color: "' . $value . '",
                        onChange: function (hsb, hex, rgb) {
                            thisElement.css("backgroundColor", "#" + hex).val("#" + hex);
                        }
                    });
                });
            });
        </script>';

        return $html;
    }
}
