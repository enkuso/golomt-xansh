<?php

namespace Enkuso\Command;

use Enkuso\Xansh\Golomt;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GolomtXanshCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('xansh:golomt')
            ->setDescription(Golomt::WIDGET_URL.'-s hanshiin medeelel tatah')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $golomtXanshTatagch = new Golomt();
        $xanshuud = $golomtXanshTatagch->xanshTatah();

        $output->writeln($xanshuud);
    }
}