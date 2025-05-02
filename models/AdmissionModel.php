<?php

class AdmissionModel
{
    private $table_user = TB_ADMISSION_USER;
    private $table_info = TB_ADMISSION_INFO;
    private $table_personal = TB_ADMISSION_PERSONAL;
    private $table_family = TB_ADMISSION_FAMILY;
    private $table_education = TB_ADMISSION_EDUCATION;
    private $table_medical = TB_ADMISSION_MEDICAL;

    private $table_control = TB_ADMISSION_CONTROL;

    #region User
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
    #endregion

    #region Admission
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
        updateData($this->table_info, [
            'admission_Entry',
            'admission_TypeApplicant',
            'admission_Strand',
            'admission_TypeStudent',
            'admission_LRN',
            'admission_Program'
        ], $data, 'admission_ID', $id);
    }

    public function getAdmissionInformation($id)
    {
        return fetchData($this->table_info, [
            'admission_Entry',
            'admission_TypeApplicant',
            'admission_Strand',
            'admission_TypeStudent',
            'admission_LRN',
            'admission_Program'
        ], 'admission_ID', $id);
    }

    public function userLRNExists($lrn, $id)
    {
        return checkForData($this->table_info, [['admission_LRN', '=', $lrn], ['admission_ID', '!=', $id]]);
    }
    #endregion

    #region Personal
    public function userPersonalInfoExists($id)
    {
        return checkForData($this->table_personal, [['admission_ID', '=', $id]]);
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

    public function getPersonalInformation($id)
    {
        return fetchData($this->table_personal, '*', 'admission_ID', $id);
    }
    #endregion

    #region Family
    public function userFamilyInfoExists($id)
    {
        return checkForData($this->table_family, [['admission_ID', '=', $id]]);
    }

    public function createFamilyInformation($data, $id)
    {
        insertData($this->table_family, [
            'admission_ID',
            'admission_FatherName',
            'admission_FatherNumber',
            'admission_FatherOccupation',
            'admission_MotherName',
            'admission_MotherNumber',
            'admission_MotherOccupation',
            'admission_Income',
            'admission_Siblings',
            'admission_BirthOrder',
            'admission_GuardianName',
            'admission_GuardianNumber',
            'admission_GuardianOccupation',
        ], $data);
    }

    public function updateFamilyInformation($data, $id)
    {
        updateData($this->table_family, [
            'admission_ID',
            'admission_FatherName',
            'admission_FatherNumber',
            'admission_FatherOccupation',
            'admission_MotherName',
            'admission_MotherNumber',
            'admission_MotherOccupation',
            'admission_Income',
            'admission_Siblings',
            'admission_BirthOrder',
            'admission_GuardianName',
            'admission_GuardianNumber',
            'admission_GuardianOccupation',
        ], $data, 'admission_ID', $id);
    }

    public function getFamilyInformation($id)
    {
        return fetchData($this->table_family, '*', 'admission_ID', $id);
    }
    #endregion

    #region Education
    public function userEducationInfoExists($id)
    {
        return checkForData($this->table_education, [['admission_ID', '=', $id]]);
    }

    public function createEducationInformation($data, $id)
    {
        insertData($this->table_education, [
            'admission_ID',
            'admission_ElementaryName',
            'admission_ElementaryAddress',
            'admission_ElementaryYear',
            'admission_ElementaryType',
            'admission_HighschoolName',
            'admission_HighschoolAddress',
            'admission_HighschoolYear',
            'admission_HighschoolType',
            'admission_SeniorName',
            'admission_SeniorAddress',
            'admission_SeniorYear',
            'admission_SeniorType',
            'admission_VocationalName',
            'admission_VocationalAddress',
            'admission_VocationalYear',
            'admission_VocationalType'
        ], $data);
    }

    public function updateEducationInformation($data, $id)
    {
        updateData($this->table_education, [
            'admission_ID',
            'admission_ElementaryName',
            'admission_ElementaryAddress',
            'admission_ElementaryYear',
            'admission_ElementaryType',
            'admission_HighschoolName',
            'admission_HighschoolAddress',
            'admission_HighschoolYear',
            'admission_HighschoolType',
            'admission_SeniorName',
            'admission_SeniorAddress',
            'admission_SeniorYear',
            'admission_SeniorType',
            'admission_VocationalName',
            'admission_VocationalAddress',
            'admission_VocationalYear',
            'admission_VocationalType'
        ], $data, 'admission_ID', $id);
    }

    public function getEducationInformation($id)
    {
        return fetchData($this->table_education, '*', 'admission_ID', $id);
    }
    #endregion

    #region Medical
    public function userMedicalInfoExists($id)
    {
        return checkForData($this->table_medical, [['admission_ID', '=', $id]]);
    }

    public function createMedicalInformation($data, $id)
    {
        insertData($this->table_medical, [
            'admission_ID',
            'admission_Medication',
            'admission_Allergy',
            'admission_Scoliosis',
            'admission_Asthma',
            'admission_Hypertension',
            'admission_Diabetes',
            'admission_Insomnia',
            'admission_Vertigo',
            'admission_Others',
            'admission_PWD'
        ], $data);
    }

    public function updateMedicalInformation($data, $id)
    {
        updateData($this->table_medical, [
            'admission_ID',
            'admission_Medication',
            'admission_Allergy',
            'admission_Scoliosis',
            'admission_Asthma',
            'admission_Hypertension',
            'admission_Diabetes',
            'admission_Insomnia',
            'admission_Vertigo',
            'admission_Others',
            'admission_PWD'
        ], $data, 'admission_ID', $id);
    }

    public function getMedicalInformation($id)
    {
        return fetchData($this->table_medical, '*', 'admission_ID', $id);
    }
    #endregion

    #region Control
    public function controlNumberExists($id)
    {
        return checkForData($this->table_control, [['admission_ID', '=', $id]]);
    }

    public function createControlNumber($id)
    {
        if (!$this->controlNumberExists($id)) {
            return insertData($this->table_control, ['admission_ID'], [$id]);
        }
        return false;
    }

    public function getControlNumber($id)
    {
        return str_pad(fetchData($this->table_control, 'admission_ControlNumber', 'admission_ID', $id), 5, '0', STR_PAD_LEFT);
    }

    public function updateAppointment($id, $date){
        updateData($this->table_control, 'admission_Appointment', $date, 'admission_ID', $id);
    }

    public function hasAppointment($id){
        return checkForData($this->table_control, [['admission_ID', '=', $id], ['admission_Appointment', 'IS NOT NULL']]);
    }

    public function getAppointment($id)
    {
        return fetchData($this->table_control, 'admission_Appointment', 'admission_ID', $id);
    }

    public function updateExam($id, $date){
        updateData($this->table_control, 'admission_Exam', $date, 'admission_ID', $id);
    }

    public function hasExam($id){
        return checkForData($this->table_control, [['admission_ID', '=', $id], ['admission_Exam', 'IS NOT NULL']]);
    }

    public function getExam($id)
    {
        return fetchData($this->table_control, 'admission_Exam', 'admission_ID', $id);
    }

    public function updateResult($id, $date){
        updateData($this->table_control, 'admission_Result', $date, 'admission_ID', $id);
    }

    public function hasResult($id){
        return checkForData($this->table_control, [['admission_ID', '=', $id], ['admission_Result', 'IS NOT NULL']]);
    }

    public function getResult($id)
    {
        return fetchData($this->table_control, 'admission_Result', 'admission_ID', $id);
    }
    #endregion
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