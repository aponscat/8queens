<?php

namespace Omatech\Queens;

class Board
{
    private array $tiles;
    private int $record=99;
    private $solutionsArray;
    private $maxSolutionsToTrack;
    private int $totalComputedSolutions=0;
    private int $limitSearch;

    public function __construct($numSolutionsToTrack=5, $limitSearch=5)
    {
        $this->maxSolutionsToTrack=$numSolutionsToTrack;
        $this->limitSearch=$limitSearch;
        foreach (range(0, DIMENSIONS - 1) as $row) {
            foreach (range(0, DIMENSIONS - 1) as $column) {
                $tile=new Tile(new Coordinate($row, $column));
                $this->tiles[$row][$column] = $tile;
                if ($row==0)
                {
                    new Queen($tile);
                }
            }
        }

        $i=0;
        while ($i<$numSolutionsToTrack)
        {
            $this->solutionsArray[$i]=0;
            $i++;
        }
    }

    public function getTotalComputedSolutions(): string {
        return $this->totalComputedSolutions;
    }

    public function getAllTiles(): array
    {
        $ret = [];
        foreach (range(0, DIMENSIONS - 1) as $row) {
            foreach (range(0, DIMENSIONS - 1) as $column) {
                $ret[] = $this->tiles[$row][$column];
            }
        }
        return $ret;
    }

    public function getAllTilesInSameColumn(Coordinate $coordinate): array
    {
        $ret = [];
        foreach (range(0, DIMENSIONS - 1) as $row) {
                foreach (range(0, DIMENSIONS - 1) as $column) {
                    if ($column==$coordinate->getColumn())
                    {
                      $ret[] = $this->tiles[$row][$column];
                    }
                }    
        }
        return $ret;
    }

    public function moveQueens()
    {
        foreach ($this->getAllQueens() as $queen)
        {
            $tile=$queen->getTile();
            //$destinationTile=$this->getTileInOtherRow($tile->getCoordinate());
            $destinationTile=$this->getTileInOtherRowWithNoQueensInLeft($tile->getCoordinate());
            $queen->moveTo($destinationTile);
        }
    }

    public function isASolution()
    {
        $this->totalComputedSolutions++;
        $totalQueensKillQueen=0;
        foreach ($this->getAllQueens() as $queen)
        {
            $trajectories=$queen->getAllTrajectories($this);
            $i=0;
            foreach ($trajectories as $trajectory)
            {
                $numQueens=$queen->numQueensInTrajectory($trajectory);
                $totalQueensKillQueen+=$numQueens;
                //echo "$i: $numQueens $totalQueensKillQueen, ";
                if ($totalQueensKillQueen>=$this->limitSearch)
                {
                    return false;
                }
                $i++;
            }
        }
        //echo "*** $totalQueensKillQueen ***\n";
        if ($this->record>=$totalQueensKillQueen)
        {
            $this->record=$totalQueensKillQueen;
        }

        if ($totalQueensKillQueen<=$this->maxSolutionsToTrack)
        {
            $this->solutionsArray[$totalQueensKillQueen-1]++;
        }

        return ($totalQueensKillQueen==0);
    }

    public function getSolutionsArray(): string
    {
        $ret='';
        foreach ($this->solutionsArray as $solution)
        {
            $ret.="$solution,";
        }
        $ret=substr($ret,0,-1);
        return $ret;
    }

    public function getAllQueens(): array
    {
        $ret = [];
        foreach ($this->getAllTiles() as $tile) {
                if (!$tile->isEmpty())
                {
                    $ret[] = $tile->getQueen();
                }
        
        }
        return $ret;        
    }

    function getTileInOtherRow(Coordinate $coordinate): ?Tile
    {
        $column=$coordinate->getColumn();
        $originalRow=$coordinate->getRow();
        $rows=range(0,DIMENSIONS-1);
        shuffle($rows);
        foreach ($rows as $row)
        {
            //echo $row.'.';
            if ($row!=$originalRow)
            {
                return $this->getTile(new Coordinate($row, $column));    
            }
        }
    }

    function getTileInOtherRowWithNoQueensInLeft(Coordinate $coordinate): ?Tile
    {
        $column=$coordinate->getColumn();
        $originalRow=$coordinate->getRow();
        $rows=range(0,DIMENSIONS-1);
        shuffle($rows);
        foreach ($rows as $row)
        {
            if($column>0)
            {
                $validRow=true;
                foreach (range(0, $column-1) as $leftColumn)
                {
                    if (!$this->getTile(new Coordinate($row, $leftColumn))->isEmpty())
                    {
                        $validRow=false;                      
                    }
                }
                if ($validRow) {
                    //echo "*";
                    return $this->getTile(new Coordinate($row, $column));  
                }
            }
            else
            {
                //echo "*";
                return $this->getTile(new Coordinate($row, $column));  
            }
        }
        //echo '-';
        return $this->getTileInOtherRow($coordinate);
    }


    public function getRecord(): string
    {
        return $this->record;
    }

    public function getTile(Coordinate $coordinate): Tile
    {
        assert($coordinate->getRow()>=0 && $coordinate->getRow()<DIMENSIONS);
        assert($coordinate->getColumn()>=0 && $coordinate->getColumn()<DIMENSIONS);
        return $this->tiles[$coordinate->getRow()][$coordinate->getColumn()];
    }

    public function __toString(): string
    {
        $ret = '    ';
        foreach (range(0, DIMENSIONS - 1) as $i) {
            $ret .= "$i";
        }
        $ret .= "\n";
        $i = 0;
        foreach (range(0, DIMENSIONS - 1) as $row) {
            $ret .= "$i - ";
            foreach (range(0, DIMENSIONS - 1) as $column) {
                $ret .= $this->tiles[$row][$column];
            }
            $ret .= "\n";
            $i++;
        }
        return $ret;
    }
}
