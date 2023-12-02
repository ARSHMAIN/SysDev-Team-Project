<?php
if (isset($_POST['customerSnakeId'])) {

}
var_dump($_POST['customerSnakeId']);
$sex = Sex::geSexByName($_POST['sex']);
//var_dump($sex);
//$snake = Snake::createSnake($_SESSION['userRole'], $sex->getSexId(), $_POST['snakeOrigin']);
$knownMorphs = getPosts('knownMorph');
$possibleMorphs = getPosts('possibleMorph');
$testMorphs = getPosts('testMorph');
var_dump($knownMorphs);
var_dump($possibleMorphs);
var_dump($testMorphs);
//var_dump($_POST['snakeOrigin']);

function getPosts(string $className): array
{
    $i = 1;
    $array = [];
    while (true) {
        $key = $className . $i;
        if (isset($_POST[$key])) {
            $array[] = $_POST[$key];
        } else {
            break;
        }
        $i++;
    }
    return $array;
}