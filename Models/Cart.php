<?php
class Cart extends Model
{
    public static function getMainSnakeInfo(int $pUserId) {
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "
                SELECT *
                    FROM cart_item ci
                        JOIN test t on ci.test_id = t.test_id
                        JOIN snake s on t.snake_id = s.snake_id
                        JOIN sex sx on s.sex_id = sx.sex_id
                        JOIN customer_snake_name csn on s.snake_id = csn.snake_id
                    WHERE ci.user_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pUserId, PDO::PARAM_INT);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $mainSnakeInfos = [];
                foreach ($results as $row) {
                    $customerSnakeName = new CustomerSnakeName();
                    $customerSnakeName->setCustomerSnakeId($row['customer_snake_id']);
                    $customerSnakeName->setUserId($row['user_id']);
                    $customerSnakeName->setSnakeId($row['snake_id']);

                    $sex = new Sex();
                    $sex->setSexId($row['sex_id']);
                    $sex->setSexName($row['sex_name']);

                    $snake = new Snake();
                    $snake->setSnakeId($row['snake_id']);
                    $snake->setUserId($row['user_id']);
                    $snake->setSexId($row['sex_id']);
                    $snake->setSnakeOrigin($row['snake_origin']);

                    $mainSnakeInfos[] = [
                        'customerSnakeName' => $customerSnakeName,
                        'sex' => $sex,
                        'snake' => $snake
                    ];
                }
                return $mainSnakeInfos;
            }
            return null;
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }
    public static function getKnownAndPossibleMorphs(int $pUserId) {
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "
                SELECT *
                    FROM cart_item ci
                        JOIN test t on ci.test_id = t.test_id
                        JOIN snake s on t.snake_id = s.snake_id
                        JOIN known_possible_morph kpm on s.snake_id = kpm.snake_id
                        JOIN morph m on kpm.morph_id = m.morph_id
                    WHERE ci.user_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pUserId, PDO::PARAM_INT);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $knownAndPossibleMorphsData = [];
                foreach ($results as $row) {
                    $morph = new Morph();
                    $morph->setMorphId($row['morph_id']);
                    $morph->setMorphName($row['morph_name']);
                    $morph->setIsTested($row['is_tested']);

                    $knownAndPossibleMorph = new KnownPossibleMorph();
                    $knownAndPossibleMorph->setSnakeId($row['snake_id']);
                    $knownAndPossibleMorph->setMorphId($row['morph_id']);
                    $knownAndPossibleMorph->setIsKnown($row['is_known']);

                    $key = $knownAndPossibleMorph->getSnakeId();
                    if ($knownAndPossibleMorph->isKnown()) {
                        if (array_key_exists($key, $knownAndPossibleMorphsData)) {
                            $knownAndPossibleMorphsData[$key]['known'][] = $morph->getMorphName();
                        } else {
                            $knownAndPossibleMorphsData[$key]['known'] = [$morph->getMorphName()];
                        }
                    } else {
                        if (array_key_exists($key, $knownAndPossibleMorphsData)) {
                            $knownAndPossibleMorphsData[$key]['possible'][] = $morph->getMorphName();
                        } else {
                            $knownAndPossibleMorphsData[$key]['possible'] = [$morph->getMorphName()];
                        }
                    }
                    /*$key = $knownAndPossibleMorph->getSnakeId();
                    if ($knownAndPossibleMorph->getIsKnown())
                    if (array_key_exists($key, $data)) {
                        $data[$key][] = $morph->getMorphName();
                    } else {
                        $data[$key] = [$morph->getMorphName()];
                    }*/
                }
                return $knownAndPossibleMorphsData;
            }
            return null;
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }
    public static function getTestedMorphs(int $pUserId) {
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "
                SELECT *
                    FROM cart_item ci
                        JOIN test t on ci.test_id = t.test_id
                        JOIN tested_morph tm on t.test_id = tm.test_id
                        JOIN morph m on tm.morph_id = m.morph_id
                    WHERE ci.user_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pUserId, PDO::PARAM_INT);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $testedMorphs = [];
                foreach ($results as $row) {
                    $morph = new Morph();
                    $morph->setMorphId($row['morph_id']);
                    $morph->setMorphName($row['morph_name']);
                    $morph->setIsTested($row['is_tested']);

                    $test = new Test();
                    $test->setTestId($row['test_id']);
                    $test->setSnakeId($row['snake_id']);
                    $test->setOrderId($row['order_id']);
                    $test->setUserId($row['user_id']);

                    $key = $test->getSnakeId();
                    if (array_key_exists($key, $testedMorphs)) {
                        $testedMorphs[$key][] = $morph->getMorphName();
                    } else {
                        $testedMorphs[$key] = [$morph->getMorphName()];
                    }
                }
                return $testedMorphs;
            }
            return null;
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }
}