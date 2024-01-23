<?php

namespace MyApp\Models;
use Config\Database;
use PDO;
use PDOException;

class Address extends Database
{
    private int $addressId = -1;
    private string $streetNumber = "";
    private string $streetName = "";
    private string $city = "";
    private string $stateOrRegion = "";
    private string $postalCode = "";
    private string $country = "";
    private int $userId = -1;

    public function __construct(
        int    $pAddressId = -1,
        string $pStreetNumber = "",
        string $pStreetName = "",
        string $pCity = "",
        string $pStateOrRegion = "",
        string $pPostalCode = "",
        string $pCountry = "",
        int    $pUserId = -1
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
        int    $pAddressId,
        string $pStreetNumber,
        string $pStreetName,
        string $pCity,
        string $pStateOrRegion,
        string $pPostalCode,
        string $pCountry,
        int    $pUserId
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
            $this->getByUserId($pUserId);
        }
    }

    private function getByUserId(int $pUserId): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM address WHERE user_id = :user_id";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(':user_id', $pUserId, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $this->addressId = $result['address_id'];
                $this->streetNumber = $result['street_number'];
                $this->streetName = $result['street_name'];
                $this->city = $result['city'];
                $this->stateOrRegion = $result['state_or_region'];
                $this->postalCode = $result['postal_code'];
                $this->country = $result['country'];
                $this->userId = $pUserId;
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt?->closeCursor();
            $dBConnection = null;
        }
    }

    public static function createAddress(int $pUserId, array $postFields): bool
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            foreach ($postFields as $key => $value) {
                if ($value === '') {
                    $postFields[$key] = null;
                }
            }

            $sql = "INSERT INTO address (street_number, street_name, city, state_or_region, postal_code, country, user_id) 
                    VALUES (:street_number, :street_name, :city, :state_or_region, :postal_code, :country, :user_id)";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(':street_number', $postFields['street_number'], PDO::PARAM_STR);
            $stmt->bindParam(':street_name', $postFields['street_name'], PDO::PARAM_STR);
            $stmt->bindParam(':city', $postFields['city'], PDO::PARAM_STR);
            $stmt->bindParam(':state_or_region', $postFields['state_or_region'], PDO::PARAM_STR);
            $stmt->bindParam(':postal_code', $postFields['postal_code'], PDO::PARAM_STR);
            $stmt->bindParam(':country', $postFields['country'], PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $pUserId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();
            $addressId = $dBConnection->lastInsertId();
        } catch (PDOException $e) {
            // Handle specific error conditions
            if ($e->getCode() == '23000') {
                // Handle duplicate key error or other specific error
                die("Error: " . $e->getMessage());
            }
        } finally {
            $stmt?->closeCursor();
            $dBConnection = null;
        }

        return $isSuccessful;
    }

    public static function updateAddress(int $pUserId, array $postFields): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            foreach ($postFields as $key => $value) {
                if ($value === '') {
                    $postFields[$key] = null;
                }
            }

            $sql = "UPDATE address 
                    SET street_number = :street_number, street_name = :street_name, city = :city, 
                        state_or_region = :state_or_region, postal_code = :postal_code, country = :country 
                    WHERE user_id = :user_id";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(':street_number', $postFields['street_number'], PDO::PARAM_STR);
            $stmt->bindParam(':street_name', $postFields['street_name'], PDO::PARAM_STR);
            $stmt->bindParam(':city', $postFields['city'], PDO::PARAM_STR);
            $stmt->bindParam(':state_or_region', $postFields['state_or_region'], PDO::PARAM_STR);
            $stmt->bindParam(':postal_code', $postFields['postal_code'], PDO::PARAM_STR);
            $stmt->bindParam(':country', $postFields['country'], PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $pUserId, PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            // Handle specific error conditions
            if ($e->getCode() == '23000') {
                // Handle duplicate key error or other specific error
                die("Error: " . $e->getMessage());
            }
        } finally {
            $stmt?->closeCursor();
            $dBConnection = null;
        }
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
