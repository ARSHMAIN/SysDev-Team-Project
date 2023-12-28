<?php
class AuthenticationMiddleware
{

    // Could be replaced with the error404 page
    public static function blockAccess($userId, $userRole, $permission): void
    {
        if (!isset($userRole)
            || !isset($userId)
            || !in_array($permission, $userRole)) {
            header("Location: index.php?controller=home&action=home");
        }
    }
}