<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OAuthCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager');
        $client = $clientManager->createClient();

        $client->setRedirectUris($input->getOption('redirect-uri'));
        $client->setAllowedGrantTypes($input->getOption('grant-type'));
        $clientManager->updateClient($client);

        $output->writeln(
            sprintf(
                'Added a new client with public id <info>%s</info>, secret <info>%s</info>',
                $client->getPublicId(),
                $client->getSecret()
            )
        );

    
        return Command::SUCCESS;
    }   
}