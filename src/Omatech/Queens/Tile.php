<?php
namespace Omatech\Queens;

class Tile
{
    private ?Queen $queen;
    private Coordinate $coordinate;

    public function __construct(Coordinate $coordinate)
    {
        $this->coordinate=$coordinate;
    }

    public function setQueen(Queen $queen): void
    {
        $this->queen=$queen;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function getQueen(): ?Queen
    {
        if (isset($this->queen)) {
            return $this->queen;
        }
        return null;
    }

    public function getSymbol(): ?string
    {
        if (isset($this->queen)) {
            return $this->queen->getSymbol();
        }
        return '-';
    }

    public function removeQueen(): void
    {
        if (isset($this->queen)) {
            $this->queen=null;
        }
    }

    public function isEmpty(): bool
    {
        return ($this->getQueen()==null);
    }

    public function getRow(): int
    {
        return $this->coordinate->getRow();
    }

    public function getColumn(): int
    {
        return $this->coordinate->getColumn();
    }

    public function __toString(): string
    {
        return $this->getSymbol();
    }

    public function debugString(): string
    {
        $ret="\ntile debug: coordinates=".$this->getCoordinates();
        if ($this->getToken()) {
            return $ret." queen=".$this->getSymbol()."\n";
        } else {
            return "$ret\n";
        }
    }
}
