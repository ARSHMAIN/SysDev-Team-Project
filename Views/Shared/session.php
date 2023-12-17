<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();

}
function noAccess($userId, $userRole, $permission): void
{
    if (!isset($userRole)
        || !isset($userId)
        || !in_array($permission, $userRole)) {
        header("Location: /?controller=home&action=home");
    }
}