<?php
include_once 'Views/Shared/session.php';
class HomeController
{
    function route(): void
    {
        global $action;
        if ($action == "home"){
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        $phpFilePath = "Views/Home/{$action}.php";
        $jsFilePath = "Views/Home/{$action}.js";
        if (file_exists($phpFilePath)) {
            extract($data);
            include_once $phpFilePath;
        } else if (file_exists($jsFilePath)) {
            echo "<script>let phpData = " . json_encode($data) . ";</script>";
            echo "<script src='{$jsFilePath}'></script>";
        } else {
            echo "File not found";
        }
    }
}
