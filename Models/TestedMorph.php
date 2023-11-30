<?php


include_once 'database.php';
class TestedMorph
{
    private int $testId = -1;
    private int $morphId = -1;
    private string $result = "";
    private string $comment = "";
    private string $resultImagePath = "";
    function __construct(
        $pTestId = -1,
        $pMorphId = -1,
        $pResult = "",
        $pComment = "",
        $pResultImagePath = "",
    ) {
        $this->initializeProperties(
            $pTestId,
            $pMorphId,
            $pResult,
            $pComment,
            $pResultImagePath
        );
    }

    private function initializeProperties(
        $pTestId,
        $pMorphId,
        $pResult,
        $pComment,
        $pResultImagePath
    ): void
    {
        if ($pTestId < 0) return;
        else if (
            $pTestId > 0
            && $pMorphId > 0
            && strlen($pResult) > 0
            && strlen($pComment) > 0
            && strlen($pResultImagePath) > 0
        ) {
            $this->testId = $pTestId;
            $this->morphId = $pMorphId;
            $this->result = $pResult;
            $this->comment = $pComment;
            $this->resultImagePath = $pResultImagePath;
        }
    }
    public static function getAllTestedMorphById(int $pTestId): ?array
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM testedmorph WHERE test_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pTestId);
        $stmt->execute();
        $results = $stmt->get_result();
        if ($results->num_rows > 0) {
            $testedMorphs = [];
            while ($row = $results->fetch_assoc()){
                $testedMorph = new TestedMorph();
                $testedMorph->testId = $pTestId;
                $testedMorph->morphId = $row['morph_id'];
                $testedMorph->result = $row['result'] || null;
                $testedMorph->comment = $row['comment'] || null;
                $testedMorph->resultImagePath = $row['result_image_path'] || null;
                $testedMorphs[] = $testedMorph;
            }
            return $testedMorphs;
        }
        return null;
    }
    public static function createTestedMorph(array ...$postFields): bool
    {
        $dBConnection = openDatabaseConnection();

        foreach ($postFields as $key => $value) {
            if ($value === '') {
                $postFields[$key] = null;
            }
        }
        $testId = array_shift($postFields);

        $sql = "INSERT INTO testedmorph (test_id, morph_id, result, comment, result_image_path) VALUES (?, ?, ?, ?, ?)";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('iisss', $testId, ...$postFields);
        $isSuccessful = $stmt->execute();
        $stmt->close();
        $dBConnection->close();
        return $isSuccessful;
    }
    //TODO do view first then make this function work
    public static function updateTestedMorph(int $pUserId, array $postFields): void
    {
        $dBConnection = openDatabaseConnection();

        foreach ($postFields as $key => $value) {
            if ($value === '') {
                $postFields[$key] = null;
            }
        }

        $sql = "UPDATE user SET first_name = ?, last_name = ?, password = ?, phone_number = ?, company_name = ?, role_id = ? WHERE user_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('sssssii', $postFields['firstName'], $postFields['lastName'], $postFields['password'], $postFields['phoneNumber'], $postFields['companyName'], $postFields['roleId'], $pUserId);
        $stmt->execute();
        $stmt->close();
        $dBConnection->close();
    }
    //TODO might need to change this
    public static function deleteTestedMorph(int $pTestId, int $pMorphId): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "DELETE FROM testedmorph WHERE test_id = ? AND morph_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pTestId, $pMorphId);
        $stmt->execute();
        $stmt->close();
        $dBConnection->close();
    }

    public function getTestId(): int
    {
        return $this->testId;
    }

    public function setTestId(int $testId): void
    {
        $this->testId = $testId;
    }

    public function getMorphId(): int
    {
        return $this->morphId;
    }

    public function setMorphId(int $morphId): void
    {
        $this->morphId = $morphId;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function setResult(string $result): void
    {
        $this->result = $result;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getResultImagePath(): string
    {
        return $this->resultImagePath;
    }

    public function setResultImagePath(string $resultImagePath): void
    {
        $this->resultImagePath = $resultImagePath;
    }

}
