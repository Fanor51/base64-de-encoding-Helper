<?php
declare(strict_types=1);

namespace Fanor51\Base64\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:EncodeCommand')]
class EncodeCommand extends Command
{
    protected function configure()
    {
        $this->addArgument('imageString', InputArgument::REQUIRED, 'Image Key');
        $this->addArgument('jsonConfigFile', InputArgument::REQUIRED, 'Json config file');
    }

    /**
     * @throws \JsonException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $imageString = $input->getArgument('imageString');
        $jsonConfigFile = $input->getArgument('jsonConfigFile');

        $filesystem = new Filesystem();
        $jsonConfigFileAndDir = __DIR__ . '/../../..' . $_ENV['JSON_SAVE_PATH'] . $jsonConfigFile . '.json';

        if (!$filesystem->exists($jsonConfigFileAndDir)) {
            $io->error(sprintf('%s.json -> File not found', $jsonConfigFile));
            return command::FAILURE;
        }

        $jsonConfig = file_get_contents($jsonConfigFileAndDir);
        $jsonConfig = json_decode($jsonConfig, true, 512, JSON_THROW_ON_ERROR);
        $jsonConfig['key'] = $imageString;

        if (isset($_ENV['CLOUDFRONT_URL'])) {
            $io->note($_ENV['CLOUDFRONT_URL']);
        }

        echo(base64_encode(json_encode($jsonConfig, JSON_THROW_ON_ERROR)));
        $io->newLine(2);

        return command::SUCCESS;
    }
}