<?php

class AdmissionModel
{
    private $table_info = TB_ADMISSION_INFO;
    private $table_personal = TB_ADMISSION_PERSONAL;
    private $table_family = TB_ADMISSION_FAMILY;
    private $table_education = TB_ADMISSION_EDUCATION;
    private $table_medical = TB_ADMISSION_MEDICAL;

    private $table_control = TB_ADMISSION_CONTROL;

    #region Admission
    public function updateUserBranch($branch, $id)
    {
        if ($this->userBranchExists($id)) {
            updateData($this->table_info, 'admission_Branch', $branch, [['admission_ID', '=', $id]]);
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
        return fetchData($this->table_info, 'admission_Branch', [['admission_ID', '=', $id]]);
    }

    public function deleteUserBranch($id)
    {
        updateData($this->table_info, 'admission_Branch', null, [['admission_ID', '=', $id]]);
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
        ], $data, [['admission_ID', '=', $id]]);
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
        ], [['admission_ID', '=', $id]]);
    }

    public function userLRNExists($lrn, $id)
    {
        return checkForData($this->table_info, [['admission_LRN', '=', $lrn], ['admission_ID', '!=', $id]]);
    }

    public function userAdmissionInfoExists($id)
    {
        return checkForData($this->table_info, [['admission_ID', '=', $id], ['admission_Entry', 'IS NOT NULL']]);
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
        ], $data, [['admission_ID', '=', $id]]);
    }

    public function getPersonalInformation($id)
    {
        return fetchData($this->table_personal, '*', [['admission_ID', '=', $id]]);
    }

    public function getFullName($id)
    {
        $dataRaw = fetchData($this->table_personal, ['admission_FirstName', 'admission_MiddleName', 'admission_LastName', 'admission_Suffix'], [['admission_ID', '=', $id]]);
        $data = $dataRaw[0] ?? [];

        $fname = $data['admission_FirstName'] ?? null;
        $mname = $data['admission_MiddleName'] ?? null;
        $lname = $data['admission_LastName'] ?? null;
        $suffix = $data['admission_Suffix'] ?? null;

        $fullName = $lname . $fname . $mname . $suffix;

        if (empty($fullName)) {
            return null;
        }

        return $lname . ', ' . $fname . ' ' . $mname . ' ' . $suffix;
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
        ], $data, [['admission_ID', '=', $id]]);
    }

    public function getFamilyInformation($id)
    {
        return fetchData($this->table_family, '*', [['admission_ID', '=', $id]]);
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
        ], $data, [['admission_ID', '=', $id]]);
    }

    public function getEducationInformation($id)
    {
        return fetchData($this->table_education, '*', [['admission_ID', '=', $id]]);
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
        ], $data, [['admission_ID', '=', $id]]);
    }

    public function getMedicalInformation($id)
    {
        return fetchData($this->table_medical, '*', [['admission_ID', '=', $id]]);
    }
    #endregion

    #region Control
    public function verifyControlNumber($num)
    {
        return checkForData($this->table_control, [['admission_ControlNumber', '=', $num]]);
    }

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
        return str_pad(fetchData($this->table_control, 'admission_ControlNumber', [['admission_ID', '=', $id]]), 5, '0', STR_PAD_LEFT);
    }

    public function getIDFromControlNumber($num)
    {
        return fetchData($this->table_control, 'admission_ID', [['admission_ControlNumber', '=', $num]]);
    }

    public function updateAppointment($id, $date)
    {
        updateData($this->table_control, 'admission_Appointment', $date, [['admission_ID', '=', $id]]);
    }

    public function hasAppointment($id)
    {
        return checkForData($this->table_control, [['admission_ID', '=', $id], ['admission_Appointment', 'IS NOT NULL']]);
    }

    public function getAppointment($id)
    {
        return fetchData($this->table_control, 'admission_Appointment', [['admission_ID', '=', $id]]);
    }

    public function updateExam($id, $date)
    {
        updateData($this->table_control, 'admission_Exam', $date, [['admission_ID', '=', $id]]);
    }

    public function hasExam($id)
    {
        return checkForData($this->table_control, [['admission_ID', '=', $id], ['admission_Exam', 'IS NOT NULL']]);
    }

    public function getExam($id)
    {
        return fetchData($this->table_control, 'admission_Exam', [['admission_ID', '=', $id]]);
    }

    public function updateResult($id, $result)
    {
        updateData($this->table_control, 'admission_Result', $result, [['admission_ID', '=', $id]]);
    }

    public function hasResult($id)
    {
        return checkForData($this->table_control, [['admission_ID', '=', $id], ['admission_Result', 'IS NOT NULL']]);
    }

    public function getResult($id)
    {
        return fetchData($this->table_control, 'admission_Result', [['admission_ID', '=', $id]]);
    }

    public function getRequirements($id)
    {
        return fetchData($this->table_control, ['admission_Picture', 'admission_Folder', 'admission_Certificate'], [['admission_ID', '=', $id]]);
    }

    public function updateRequirements($data, $id)
    {
        updateData($this->table_control, ['admission_Picture', 'admission_Folder', 'admission_Certificate'], $data, [['admission_ID', '=', $id]]);
    }
    #endregion
}
    
    
        // public function getUserData($userId)
        // {
        //     return fetchData($this->table, '*', 'admission_ID', $userId);
        // }
    
        // public function updateUserData($userId, $data)
        // {
        //     return updateData($this->table, $data, [['admission_ID', '=', $userId]]);
        // }
    
        // public function deleteUser($userId)
        // {
        //     return deleteData($this->table, 'admission_ID', $userId);
        // }