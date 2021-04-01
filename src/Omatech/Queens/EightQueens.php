<?php

namespace Omatech\Queens;

class EightQueens
{
    private IO $io;

    public function __construct()
    {
        $this->io = new IO();
    }

    public function findSolution($numSolutionsToTrack=5, $limitSearch=5): void
    {
        $board = new Board($numSolutionsToTrack, $limitSearch);

        do {
            //usleep(10000);
            $this->io->clearScreen();
            $this->io->printBoard($board);
            $board->moveQueens();
        } while (!$board->isASolution());

        $this->io->clearScreen();
        echo "Is a valid solution!\n";
        $this->io->printBoard($board);
    }
}
