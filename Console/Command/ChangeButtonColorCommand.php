<?php

/**
 * @copyright Copyright (c) 2025 Hibrido.
 */

declare(strict_types=1);

namespace Hibrido\ThemeCustomizer\Console\Command;

use Hibrido\ThemeCustomizer\Model\Command\GetStoreById;
use Hibrido\ThemeCustomizer\Model\Validator\HexColorValidator;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\ScopeInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeButtonColorCommand extends Command
{
    private const CONFIG_PATH = 'hibrido_theme_customizer/button/color';
    private const ARG_HEX_COLOR = 'hex_color';
    private const ARG_STORE_ID = 'store_id';

    /**
     * ChangeButtonColorCommand Constructor
     *
     * @param HexColorValidator   $validator
     * @param GetStoreById        $storeViewResolver
     * @param WriterInterface     $configWriter
     * @param TypeListInterface   $cacheTypeList
     */
    public function __construct(
        private readonly HexColorValidator $validator,
        private readonly GetStoreById $storeViewResolver,
        private readonly WriterInterface $configWriter,
        private readonly TypeListInterface $cacheTypeList
    ) {
        parent::__construct();
    }

    /**
     * Configures the command name, description, and arguments.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('color:change')
            ->setDescription('Change button color for a specific store view')
            ->addArgument(self::ARG_HEX_COLOR, InputArgument::REQUIRED, 'Hex color (e.g. #000000 or 000000) or "reset"')
            ->addArgument(self::ARG_STORE_ID, InputArgument::REQUIRED, 'Store View ID');
    }

    /**
     * Executes the command logic.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $hexColor = ltrim((string) $input->getArgument(self::ARG_HEX_COLOR), '#');
        $storeId = (int) $input->getArgument(self::ARG_STORE_ID);

        try {
            $store = $this->storeViewResolver->execute($storeId);
            $scopeCode = $store->getCode();

            if ($hexColor === 'reset') {
                $this->configWriter->delete(self::CONFIG_PATH, ScopeInterface::SCOPE_STORES, $store->getId());
                $this->cacheTypeList->cleanType('config');
                $output->writeln("<info>Button color has been reset for store view '{$scopeCode}'.</info>");
                return Command::SUCCESS;
            }

            if (!$this->validator->isValid($hexColor)) {
                $output->writeln('<error>Invalid HEX color. Use format #000000 or 000000.</error>');
                return Command::FAILURE;
            }

            $this->configWriter->save(
                self::CONFIG_PATH,
                "#{$hexColor}",
                ScopeInterface::SCOPE_STORES,
                $store->getId()
            );

            $this->cacheTypeList->cleanType('config');
            $output->writeln("<info>Button color set to #{$hexColor} for store view '{$scopeCode}'.</info>");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }
}
