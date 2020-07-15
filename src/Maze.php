<?php

require_once 'Coordinate.php';


class Maze
{
    const ROAD = ' ';
    const WALL = '.';
    const START = 'u';
    const EXIT = 'e';
    const PATH = '*';

    const VALID_CHARS = [self::ROAD, self::WALL, self::START, self::EXIT];

    /**
     * @var array
     */
    private $maze = [];

    /**
     * @var array[bool]
     */
    private $visited = [];

    /**
     * @var Coordinate
     */
    private $start;

    /**
     * @var Coordinate
     */
    private $exit;

    /**
     * @var string
     */
    private $mazePath;

    /**
     * Maze constructor.
     * @param string $mazePath
     * @throws Exception
     */
    public function __construct(string $mazePath)
    {
        if (!file_exists($mazePath)) {
            throw new Exception('File not exits');
        }

        $this->mazePath = $mazePath;

        $this->initMaze($mazePath);
    }

    /**
     * @param string $mazePath
     * @throws Exception
     */
    public function initMaze(string $mazePath)
    {
        $file = fopen($mazePath, 'r');
        $x = 0;
        while ($line = rtrim(fgets($file))) {
            $length = strlen($line);

            if (isset($this->maze[0]) && $length !== $this->getWidth()) {
                throw new Exception('Wrong maze size.');
            }

            for ($y = 0; $y < $length; $y++) {
                $element = $line[$y];

                if (!in_array($element, self::VALID_CHARS)) {
                    throw new Exception("Invalid maze character: {$element}.");
                }

                $this->maze[$x][$y] = $element;
                $this->visited[$x][$y] = false;

                switch ($element) {
                    case self::START:
                        $this->start = new Coordinate($x, $y);
                        break;

                    case self::EXIT:
                        $this->exit = new Coordinate($x, $y);
                }
            }
            $x++;
        }

        if (!($this->start instanceof Coordinate && $this->exit instanceof Coordinate)) {
            throw new Exception('Invalid maze source.');
        }

        fclose($file);
    }

    /**
     * @return Coordinate
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function canMove(int $x, int $y)
    {
        return $this->isValidStep($x, $y) && !$this->isExplored($x, $y);
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isValidStep(int $x, int $y)
    {
        return ($x >= 0 && $x < $this->getHeight() && $y >= 0 && $y < $this->getWidth());
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isExplored(int $x, int $y)
    {
        return $this->visited[$x][$y];
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isWall(int $x, int $y)
    {
        return $this->maze[$x][$y] === self::WALL;
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isExit(int $x, int $y)
    {
        return $this->exit->getX() === $x && $this->exit->getY() === $y;
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isStart(int $x, int $y)
    {
        return $this->start->getX() === $x && $this->start->getY() === $y;
    }

    /**
     * @param int $x
     * @param int $y
     */
    public function setVisited(int $x, int $y)
    {
        $this->visited[$x][$y] = true;
    }

    /**
     * @param int $x
     * @param int $y
     */
    public function setPath(int $x, int $y)
    {
        $this->maze[$x][$y] = self::PATH;
    }

    /**
     * Draw maze
     */
    public function draw()
    {
        echo $this->mazePath . PHP_EOL;
        foreach ($this->maze as $row) {
            foreach ($row as $col) {
                echo $col;
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    /**
     * @return int
     */
    private function getWidth()
    {
        return count($this->maze[0]);
    }

    /**
     * @return int
     */
    private function getHeight()
    {
        return count($this->maze);
    }

}