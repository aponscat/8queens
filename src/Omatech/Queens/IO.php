<?php
namespace Omatech\Queens;

class IO
{
    public function printBoard(Board $board): void
    {
        echo "Current board is (".$board->getRecord().") TOTAL(".$board->getTotalComputedSolutions()."):\n";
        echo "SolutionsArray: ".$board->getSolutionsArray()."\n";
        echo $board;
    }

    public function clearScreen(): void
    {
        echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
    }
}
