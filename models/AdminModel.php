<?php


class AdminModel
{
    private $table_exam = TB_ADMIN_EXAM;

    public function examDateExists($date)
    {
        return checkForData($this->table_exam, [['exam_Date', '=', $date]]);
    }

    public function createExamDate($data, $date)
    {
        insertData($this->table_exam, [
            'exam_Date',
            'exam_DateCalendar',
            'exam_DateMeridiem',
            'exam_Capacity'
        ], $data);
    }

    public function updateExamDate($data, $date)
    {
        if (checkForData($this->table_exam, [['exam_Date', '=', $date], ['exam_Status', 'IS NULL']])) {
            updateData($this->table_exam, [
                'exam_Date',
                'exam_DateCalendar',
                'exam_DateMeridiem',
                'exam_Capacity'
            ], $data, [['exam_Date', '=', $date]]);
        }
    }

    public function updateExamStatus($data, $date)
    {
        updateData($this->table_exam, [
            'exam_Status'
        ], $data, [['exam_Date', '=', $date]]);
    }

    public function assignExamSlot($examDate)
    {
        $sql = "UPDATE tb_admission_control
                SET admission_Exam = ?
                WHERE admission_Exam IS NULL AND admission_Picture IS NOT NULL AND admission_Folder IS NOT NULL
                LIMIT 1";

        runQuery($sql, [$examDate]);
    }

    public function updateExamOccupied($data, $date)
    {
        updateData($this->table_exam, [
            'exam_Occupied'
        ], $data, [['exam_Date', '=', $date]]);
    }

    public function deleteExamDate($date)
    {
        deleteData($this->table_exam, [['exam_Date', '=', $date]]);
    }
}
