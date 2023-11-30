<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();

}
function noAccess($userId, $userRoles, $permission): void
{
    if (!isset($userRoles)
        || !isset($userId)
        || !in_array($permission, $userRoles)) {
        header("Location: /?controller=home&action=home");
    }
}