<?php
class Controller
{
    protected function render(array $data = []): void
    {
        global $controllerPrefix, $action;
        extract($data);
        include_once "Views/$controllerPrefix/$action.php";
    }
    public static function loadAuthentication(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    protected function blockAccess($userId, $userRole, $permission): void
    {
        if (!isset($userRole)
            || !isset($userId)
            || !in_array($permission, $userRole)) {
            header("Location: index.php?controller=home&action=home");
        }
    }
}