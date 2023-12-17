<?php
if (isset($_GET['id'])) {
    $test = new Test($_GET['id']);
    if ($test->getTestId() !== null) {
        $allTests = Test::getBySnakeId($test->getSnakeId());
        if ($allTests['isSuccessful'] === true && sizeof($allTests['tests']) <= 1) {
            Snake::deleteSnake($test->getSnakeId());
        } else {
            $deletedTest = Test::deleteTest($test->getTestId());
        }
    }
}
header('Location: ?controller=cart&action=cart');