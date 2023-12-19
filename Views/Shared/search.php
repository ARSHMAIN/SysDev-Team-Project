<?php
function search(string $controller, string $action): void
{
    echo "<form action='?controller=" . $controller . "&action=" . $action . "' method='post'>
            <input type='search' name='search' placeholder='search'>
            <input type='submit' name='submit' value='Search'>
            </form>";
}
