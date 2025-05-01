<?php

class AdmissionModel
{
    private $table_user = TB_ADMISSION_USER;
    private $table_info = TB_ADMISSION_INFO;
    private $table_personal = TB_ADMISSION_PERSONAL;
    private $table_family = TB_ADMISSION_FAMILY;
    private $table_education = TB_ADMISSION_EDUCATION;
    private $table_medical = TB_ADMISSION_MEDICAL;

    public function userExists($email)
    {
        return checkForData($this->table_user, [['admission_Email', '=', $email]]);
    }

    public function getUserPassword($email)
    {
        return fetchData($this->table_user, 'admission_Password', 'admission_Email', $email);
    }

    public function getUserID($email)
    {
        return fetchData($this->table_user, 'admission_ID', 'admission_Email', $email);
    }

    public function createUser($email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return insertData($this->table_user, ['admission_Email', 'admission_Password'], [$email, $hashedPassword]);
    }

    public function updateUserBranch($branch, $id)
    {
        if ($this->userBranchExists($id)) {
            updateData($this->table_info, 'admission_Branch', $branch, 'admission_ID', $id);
        } else {
            insertData($this->table_info, ['admission_ID', 'admission_Branch'], [$id, $branch]);
        }
    }

    public function userBranchExists($id)
    {
        return checkForData($this->table_info, [['admission_ID', '=', $id]]);
    }

    public function getUserBranch($id)
    {
        return fetchData($this->table_info, 'admission_Branch', 'admission_ID', $id);
    }

    public function deleteUserBranch($id)
    {
        updateData($this->table_info, 'admission_Branch', null, 'admission_ID', $id);
    }

    public function updateAdmissionInformation($data, $id)
    {
        updateData($this->table_info, ['admission_Entry', 'admission_TypeApplicant', 'admission_Strand', 'admission_TypeStudent', 'admission_LRN', 'admission_Program'], $data, 'admission_ID', $id);
    }

    public function getAdmissionInformation($id)
    {
        return fetchData($this->table_info, ['admission_Entry', 'admission_TypeApplicant', 'admission_Strand', 'admission_TypeStudent', 'admission_LRN', 'admission_Program'], 'admission_ID', $id);
    }

    public function userLRNExists($lrn, $id)
    {
        return checkForData($this->table_info, [['admission_LRN', '=', $lrn], ['admission_ID', '!=', $id]]);
    }

    public function userPersonalInfoExists($id)
    {
        return checkForData($this->table_personal, [['admission_ID', '=', $id]]);
    }

    public function updatePersonalInformation($data, $id)
    {
        updateData($this->table_personal, [
            'admission_ID',
            'admission_FirstName',
            'admission_MiddleName',
            'admission_LastName',
            'admission_Suffix',
            'admission_Region',
            'admission_Province',
            'admission_ContactNumber',
            'admission_LandlineNumber',
            'admission_CivilStatus',
            'admission_Sex',
            'admission_BirthDate',
            'admission_BirthPlace',
            'admission_Religion',
            'admission_Indigenous'
        ], $data, 'admission_ID', $id);
    }

    public function createPersonalInformation($data, $id)
    {
        insertData($this->table_personal, [
            'admission_ID',
            'admission_FirstName',
            'admission_MiddleName',
            'admission_LastName',
            'admission_Suffix',
            'admission_Region',
            'admission_Province',
            'admission_ContactNumber',
            'admission_LandlineNumber',
            'admission_CivilStatus',
            'admission_Sex',
            'admission_BirthDate',
            'admission_BirthPlace',
            'admission_Religion',
            'admission_Indigenous'
        ], $data);
    }
}
    
    
        // public function getUserData($userId)
        // {
        //     return fetchData($this->table, '*', 'admission_ID', $userId);
        // }
    
        // public function updateUserData($userId, $data)
        // {
        //     return updateData($this->table, $data, 'admission_ID', $userId);
        // }
    
        // public function deleteUser($userId)
        // {
        //     return deleteData($this->table, 'admission_ID', $userId);
        // }