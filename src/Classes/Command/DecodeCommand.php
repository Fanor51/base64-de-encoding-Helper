<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:DecodeCommand')]
class DecodeCommand extends Command
{
    protected function configure()
    {
        $this->addArgument('hashString', InputArgument::REQUIRED, 'Image Hash');
        $this->addArgument('config', InputArgument::OPTIONAL, 'Show whole config');
        $this->addArgument(
            'saveConfig',
            InputArgument::OPTIONAL,
            sprintf('Save image config under %s{timestamp}.json', getenv('JSON_SAVE_PATH')));
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws \JsonException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $hashString = $input->getArgument('hashString');

        $json = base64_decode($hashString);
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $io->definitionList(
            ['Hash' => $hashString ?? 'n.A',],
            ['Image' => $data['key'] ?? 'n.A'],
            ['outputFormat' => $data['outputFormat'] ?? 'n.A']
        );

        if (filter_var($input->getArgument('config'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)) {
            print_r($data);
        }

        if (filter_var($input->getArgument('saveConfig'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)) {
            $filesystem = new Filesystem();

            $saveDir = __DIR__ . '/../..' . $_ENV['JSON_SAVE_PATH'];

            $jsonFileName = new \DateTime();
            $jsonFileName = $jsonFileName->getTimestamp();

            $filesystem->mkdir($saveDir);
            $filesystem->dumpFile($saveDir . $jsonFileName . '.json', $json);
        }

        return command::SUCCESS;
    }
}