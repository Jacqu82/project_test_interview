<?php

declare(strict_types=1);

namespace App\Command;

use App\Provider\CodeListProvider;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Jacek Wesołowski <jacqu25@yahoo.com>
 */
class GenerateCodeCommand extends Command
{
    protected static $defaultName = 'app:generate-code';

    private $codeListProvider;

    private $varDirectory;

    public function __construct(CodeListProvider $codeListProvider, string $varDirectory)
    {
        $this->codeListProvider = $codeListProvider;
        $this->varDirectory = $varDirectory;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Generates a random bonus code(s)')
            ->addArgument('quantity', InputArgument::REQUIRED, 'Code\'s quantity')
            ->addArgument('length', InputArgument::REQUIRED, 'Code\'s length')
            ->addArgument(
                'type',
                InputArgument::OPTIONAL,
                'Code\'s type - option "0" generates digits and letters, option "1" digits only',
                0
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        if (0 !== (int)$input->getArgument('type') && 1 !== (int)$input->getArgument('type')) {
            return;
        }

        $quantity = (int)$input->getArgument('quantity');
        $length = (int)$input->getArgument('length');
        $type = (bool)$input->getArgument('type');

        $codes = $this->codeListProvider->generateRandomCodeList($length, $quantity, $type);

        $io->note(sprintf('Quantity: %s', $quantity));
        $io->note(sprintf('Length: %s', $length));
        $io->note(sprintf('Type: %s', false === $type ? 'Digits and letters' : 'Digits'));

        if (!empty($codes)) {
            if (!file_exists($this->varDirectory) && !mkdir(
                    $concurrentDirectory = $this->varDirectory,
                    0777,
                    true
                ) && !is_dir($concurrentDirectory)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            file_put_contents(
                $this->varDirectory . '/' . uniqid('', true) . '.txt',
                implode(PHP_EOL, $codes)
            );

            $io->success(sprintf('Code(s) successfully generated and saved:%s %s', PHP_EOL, implode(', ', $codes)));
        }
    }
}
