<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();

}
function noAccess($userId, $userRoles, $permission): void
{
    if (!isset($userRole)
        || !isset($userId)
        || !in_array($permission, $userRole)) {
        header("Location: /?controller=home&action=home");
    }
}