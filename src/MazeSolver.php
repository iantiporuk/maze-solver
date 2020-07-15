<?php

require_once 'Coordinate.php';

class MazeSolver
{
    const RIGHT = [0, 1];
    const LEFT = [0, -1];
    const UP = [-1, 0];
    const DOWN = [1, 0];

    const DIRECTIONS = [self::RIGHT, self::DOWN, self::UP, self::LEFT];

    /**
     * @param Maze $maze
     * @throws Exception
     */
    public function solve(Maze $maze)
    {
        $toVisit = new SplDoublyLinkedList();
        $start = $maze->getStart();
        $toVisit->push($start);

        while (!$toVisit->isEmpty()) {
            /** @var Coordinate $current */
            $current = $toVisit->shift();
            $x = $current->getX();
            $y = $current->getY();

            if ($maze->isExit($x, $y)) {
                $maze->draw();
                return;
            }

            $maze->setVisited($x, $y);
            !$maze->isStart($x, $y) && $maze->setPath($x, $y);

            foreach (self::DIRECTIONS as $direction) {

                $nextX = $x + $direction[0];
                $nextY = $y + $direction[1];

                if (!$maze->canMove($nextX, $nextY)) {
                    continue;
                }

                if ($maze->isWall($nextX, $nextY)) {
                    $maze->setVisited($nextX, $nextY);
                    continue;
                }

                $toVisit->push(new Coordinate($nextX, $nextY, $current));
            }
        }

        throw new Exception('Can not solve the maze');
    }

}