<?php

namespace App\Command;

use App\Provider\CodeProvider;
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

    private $codeProvider;

    private $varDirectory;

    public function __construct(CodeProvider $codeProvider, string $varDirectory)
    {
        $this->codeProvider = $codeProvider;
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
                'Code\'s type - 0 generates digits and letters, 1 digits only',
                0
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        $length = $input->getArgument('length');
        $quantity = $input->getArgument('quantity');
        $type = $input->getArgument('type');

        $codes = $this->codeProvider->generateRandomCodeList($length, $quantity, $type);

        if ($length) {
            $io->note(sprintf('Length: %s', $length));
        }

        if ($quantity) {
            $io->note(sprintf('Quantity: %s', $quantity));
        }

        $io->note(sprintf('Type: %s', 0 === $type ? 'digits and letters' : 'digits'));

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

            $io->success(sprintf('Codes successfully generated and saved:%s %s', PHP_EOL, implode(', ', $codes)));
        }
    }
}
