<?php

declare(strict_types=1);

/*
 * This file is part of the Runroom package.
 *
 * (c) Runroom <runroom@runroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Runroom\UserBundle\Command;

use Runroom\UserBundle\Util\UserManipulator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'runroom:user:change-password', description: 'Change the password of a user.')]
final class ChangePasswordCommand extends Command
{
    public function __construct(private readonly UserManipulator $userManipulator)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('identifier', InputArgument::REQUIRED, 'The identifier')
            ->addArgument('password', InputArgument::REQUIRED, 'The password')
            ->setHelp(
                <<<'EOT'
The <info>%command.full_name%</info> command changes the password of a user:

  <info>php %command.full_name% my@email.com new-password</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $identifier = $input->getArgument('identifier');
        $password = $input->getArgument('password');

        $this->userManipulator->changePassword($identifier, $password);

        $output->writeln(\sprintf('Changed password for user <comment>%s</comment>', $identifier));

        return 0;
    }
}
