<?php
namespace Omatech\Queens;

class Queen
{
    private string $symbol;
    private Tile $tile;

    public function __construct(Tile $tile)
    {
        $this->tile=$tile;
        $this->symbol='o';
        $tile->setQueen($this);
    }

    public function getTile(): Tile
    {
        return $this->tile;
    }

    public function getNextRow(int $offset=1): int
    {
        return $this->getTile()->getRow()+($this->getRowOffset($offset));
    }

    public function getRowOffset(int $offset): int
    {
        return $offset*$this->row_direction;
    }

    public function getColor(): string
    {
        return $this->getPlayer()->getColor();
    }

    public function moveTo(Tile $tile): void
    {
        $this->tile->removeQueen();
        $this->tile=$tile;
        $this->tile->setQueen($this);
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getAllTrajectories($board): array
    {
        $trajectories=[];
        $trajectories[]=new Trajectory($board, $this->getTile()->getCoordinate(), 0, 1);
        $trajectories[]=new Trajectory($board, $this->getTile()->getCoordinate(), 1, 0);
        $trajectories[]=new Trajectory($board, $this->getTile()->getCoordinate(), 1, 1);
        $trajectories[]=new Trajectory($board, $this->getTile()->getCoordinate(), 1, -1);
        $trajectories[]=new Trajectory($board, $this->getTile()->getCoordinate(), -1, 1);
        $trajectories[]=new Trajectory($board, $this->getTile()->getCoordinate(), -1, -1);
        return $trajectories;
    }

    public function numQueensInTrajectory(Trajectory $trajectory): int
    {
        $ret=0;
        $tiles=$trajectory->getTiles(0);
        foreach ($tiles as $tile)
        {
            if (!$tile->isEmpty())
            {
                $ret++;
            }
        }
        return $ret;
    }

}
