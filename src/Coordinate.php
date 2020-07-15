<?php


class Coordinate
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @var Coordinate|null
     */
    private $parent;

    /**
     * Coordinate constructor.
     * @param int $x
     * @param int $y
     * @param Coordinate|null $parent
     */
    public function __construct(int $x, int $y, Coordinate $parent = null)
    {
        $this->x = $x;
        $this->y = $y;
        $this->parent = $parent;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @return Coordinate|null
     */
    public function getParent()
    {
        return $this->parent;
    }

}