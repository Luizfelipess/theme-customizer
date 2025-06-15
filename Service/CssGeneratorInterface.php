<?php

declare(strict_types=1);

namespace Hibrido\ThemeCustomizer\Service;

interface CssGeneratorInterface
{
    /**
     * Generates a CSS string based on the provided parameters.
     *
     * @param array $params
     * @return string
     */
    public function generate(array $params): string;
}
