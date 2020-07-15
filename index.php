<?php

require_once 'src/Maze.php';
require_once 'src/MazeSolver.php';

$mazes = [
    'mazes/maze1.txt',
    'mazes/maze2.txt',
    'mazes/maze3.txt',
];

foreach ($mazes as $pathToMaze) {
    try {

        $maze = new Maze($pathToMaze);
        $solver = new MazeSolver;

        $solver->solve($maze);
    } catch (Exception $exception) {
        echo $exception->getMessage() . PHP_EOL;
    }
}



