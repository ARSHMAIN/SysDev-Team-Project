<?php

namespace Models;
include_once 'database.php';

class Address
{
    private int $addressId = -1;
    private string $streetNumber = "";
    private string $streetName = "";
    private string $city = "";
    private string $stateOrRegion = "";
    private string $postalCode = "";
    private string $country = "";
    private int $userId = -1;

    function __construct(
        $pAddressId = -1,
        $pStreetNumber = "",
        $pStreetName = "",
        $pCity = "",
        $pStateOrRegion = "",
        $pPostalCode = "",
        $pCountry = "",
        $pUserId = -1
    )
    {
        $this->initializeProperties(
            $pAddressId,
            $pStreetNumber,
            $pStreetName,
            $pCity,
            $pStateOrRegion,
            $pPostalCode,
            $pCountry,
            $pUserId
        );
    }

    private function initializeProperties(
        $pAddressId,
        $pStreetNumber,
        $pStreetName,
        $pCity,
        $pStateOrRegion,
        $pPostalCode,
        $pCountry,
        $pUserId
    ): void
    {
        if ($pUserId < 0) return;
        else if (
            $pAddressId > 0
            && strlen($pStreetNumber) > 0
            && strlen($pStreetName) > 0
            && strlen($pCity) > 0
            && strlen($pStateOrRegion) > 0
            && strlen($pPostalCode) > 0
            && strlen($pCountry) > 0
            && $pUserId > 0
        ) {
            $this->addressId = $pAddressId;
            $this->streetNumber = $pStreetNumber;
            $this->streetName = $pStreetName;
            $this->city = $pCity;
            $this->stateOrRegion = $pStateOrRegion;
            $this->postalCode = $pPostalCode;
            $this->country = $pCountry;
            $this->userId = $pUserId;
        } else if ($pUserId > 0) {
            $this->getAddressByUserId($pUserId);
        }
    }

    private function getAddressByUserId($pUserId): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM address WHERE user_id = :user_id";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pUserId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $this->addressId = $result['address_id'];
            $this->streetNumber = $result['street_number'];
            $this->streetName = $result['street_name'];
            $this->city = $result['city'];
            $this->stateOrRegion = $result['state_or_region'];
            $this->postalCode = $result['postal_code'];
            $this->country = $result['country'];
            $this->userId = $pUserId;
        }
    }
    public static function createAddress(int $pUserId, array $postFields): bool
    {
        $dBConnection = openDatabaseConnection();

        foreach ($postFields as $key => $value) {
            if ($value === '') {
                $postFields[$key] = null;
            }
        }

        $sql = "INSERT INTO address (street_number, street_name, city, state_or_region, postal_code, country, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('ssssssi', $postFields['street_number'], $postFields['street_name'], $postFields['city'], $postFields['state_or_region'], $postFields['postal_code'], $postFields['country'], $pUserId);
        $isSuccessful = $stmt->execute();
        $addressId = $dBConnection->insert_id;
        $stmt->close();
        $dBConnection->close();
        return $isSuccessful;
    }
    public static function updateAddress(int $pUserId, array $postFields): void
    {
        $dBConnection = openDatabaseConnection();

        foreach ($postFields as $key => $value) {
            if ($value === '') {
                $postFields[$key] = null;
            }
        }

        $sql = "UPDATE address SET street_number = ?, street_name = ?, city = ?, state_or_region = ?, postal_code = ?, country = ? WHERE user_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('ssssssi', $postFields['street_number'], $postFields['street_name'], $postFields['city'], $postFields['state_or_region'], $postFields['postal_code'], $postFields['country'], $pUserId);
        $stmt->execute();
        $stmt->close();
        $dBConnection->close();
    }

    public function getAddressId(): int
    {
        return $this->addressId;
    }

    public function setAddressId(int $addressId): void
    {
        $this->addressId = $addressId;
    }

    public function getStreetNumber(): string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(string $streetNumber): void
    {
        $this->streetNumber = $streetNumber;
    }

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): void
    {
        $this->streetName = $streetName;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getStateOrRegion(): string
    {
        return $this->stateOrRegion;
    }

    public function setStateOrRegion(string $stateOrRegion): void
    {
        $this->stateOrRegion = $stateOrRegion;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

}