<?php
function search(string $controller, string $action): void
{
    echo "<form action='?controller=" . $controller . "&action=" . $action . "' method='post'>
            <input type='search' name='search' placeholder='find by customer snake id'>
            <input type='submit' name='submit' value='Search'>
            </form>";
}
