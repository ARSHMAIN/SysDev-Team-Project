<?php

namespace Models;

class Role
{
    private int $roleId = -1;
    private string $firstName = "";
    private string $lastName = "";
    private string $email = "";
    private string $password = "";
    private string $phoneNumber = "";
    private string $companyName = "";
    private string $registeredDate = "";
    private string $lastLogin = "";
    private int $roleId = -1;

    function __construct(
        $pUserId = -1,
        $pFirstName = "",
        $pLastName = "",
        $pEmail = "",
        $pPassword = "",
        $pPhoneNumber = "",
        $pCompanyName = "",
        $pRegisteredDate = "",
        $pLastLogin = "",
        $pRoleId = -1
    ) {
        $this->initializeProperties(
            $pUserId,
            $pFirstName,
            $pLastName,
            $pEmail,
            $pPassword,
            $pPhoneNumber,
            $pCompanyName,
            $pRegisteredDate,
            $pLastLogin,
            $pRoleId
        );
    }

    private function initializeProperties(
        $pUserId,
        $pFirstName,
        $pLastName,
        $pEmail,
        $pPassword,
        $pPhoneNumber,
        $pCompanyName,
        $pRegisteredDate,
        $pLastLogin,
        $pRoleId
    ): void
    {
        if ($pUserId < 0) return;
        else if (
            $pUserId > 0
            && strlen($pFirstName) > 0
            && strlen($pLastName) > 0
            && strlen($pEmail) > 0
            && strlen($pPassword) > 0
            && strlen($pPhoneNumber) > 0
            && strlen($pCompanyName) > 0
            && strlen($pRegisteredDate) > 0
            && strlen($pLastLogin) > 0
            && $pRoleId > 0
        ) {
            $this->userId = $pUserId;
            $this->firstName = $pFirstName;
            $this->lastName = $pLastName;
            $this->email = $pEmail;
            $this->password = $pPassword;
            $this->phoneNumber = $pPhoneNumber;
            $this->companyName = $pCompanyName;
            $this->registeredDate = $pRegisteredDate;
            $this->lastLogin = $pLastLogin;
            $this->roleId = $pRoleId;
        } else if ($pUserId > 0) {
            $this->getUserById($pUserId);
        }
    }
}