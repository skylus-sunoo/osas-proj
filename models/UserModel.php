<?php

class UserModel
{
    private $table_admin = TB_ADMIN_USER;
    private $table_admission = TB_ADMISSION_USER;

    public function tableAdmin()
    {
        return $this->table_admin;
    }

    public function tableAdmission()
    {
        return $this->table_admission;
    }

    private $columnMap = [];

    public function __construct()
    {
        $this->columnMap = [
            TB_ADMIN_USER => [
                'Email' => 'admin_Email',
                'Password' => 'admin_Password',
                'ID' => 'admin_ID'
            ],
            TB_ADMISSION_USER => [
                'Email' => 'admission_Email',
                'Password' => 'admission_Password',
                'ID' => 'admission_ID'
            ]
        ];
    }

    private function getColumn($table, $type)
    {
        if (!isset($this->columnMap[$table][$type])) {
            throw new InvalidArgumentException("Unknown column type '$type' for table: $table");
        }
        return $this->columnMap[$table][$type];
    }

    public function userExists($table, $email)
    {
        $column = $this->getColumn($table, 'Email');
        return checkForData($table, [[$column, '=', $email]]);
    }

    public function getUserPassword($table, $email)
    {
        $emailColumn = $this->getColumn($table, 'Email');
        $passwordColumn = $this->getColumn($table, 'Password');
        return fetchData($table, $passwordColumn, [[$emailColumn, '=', $email]]);
    }

    public function getUserID($table, $email)
    {
        $emailColumn = $this->getColumn($table, 'Email');
        $idColumn = $this->getColumn($table, 'ID');
        return fetchData($table, $idColumn, [[$emailColumn, '=', $email]]);
    }

    public function getUserEmail($table, $id)
    {
        $emailColumn = $this->getColumn($table, 'Email');
        $idColumn = $this->getColumn($table, 'ID');
        return fetchData($table, $emailColumn, [[$idColumn, '=', $id]]);
    }

    public function createUser($table, $email, $password)
    {
        $emailColumn = $this->getColumn($table, 'Email');
        $passwordColumn = $this->getColumn($table, 'Password');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        insertData($table, [$emailColumn, $passwordColumn], [$email, $hashedPassword]);
    }

    /**
     * Generates random data for a new user and creates the user in the admissions table.
     */
    public function createRandomUser($table)
    {
        $email = $this->generateRandomEmail();
        $password = $this->generateRandomPassword();

        $this->createUser($table, $email, $password);
    }

    /**
     * Generates a random email address.
     * 
     * @return string The randomly generated email address.
     */
    private function generateRandomEmail()
    {
        $randomString = bin2hex(random_bytes(5));  // Generate a random 10 character string
        return $randomString . "@example.com";      // Return as an email format
    }

    /**
     * Generates a random password.
     * 
     * @return string The randomly generated password.
     */
    private function generateRandomPassword()
    {
        // Define allowed characters for the password
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $password = '';
        $length = 12; // Length of the password

        // Generate a random password using the allowed characters
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $password;
    }
}
