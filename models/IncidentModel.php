<?php


class IncidentModel
{
    private $table_incident = TB_ADMIN_INCIDENT;

    public function getIncident($id)
    {
        return fetchData($this->table_incident, [['incident_ID', '=', $id]]);
    }

    public function createIncident($data)
    {
        insertData($this->table_incident, [
            'incident_Name',
            'incident_Type',
            'incident_DateTime',
            'incident_Location',
            'incident_Status',
            'incident_Description'
        ], $data);
    }

    public function updateIncident($data, $id)
    {
        if (checkForData($this->table_incident, [['incident_ID', '=', $id]])) {
            updateData($this->table_incident, [
                'incident_Name',
                'incident_Type',
                'incident_DateTime',
                'incident_Location',
                'incident_Status',
                'incident_Description'
            ], $data, [['incident_ID', '=', $id]]);
        }
    }

    public function deleteIncident($id)
    {
        deleteData($this->table_incident, [['incident_ID', '=', $id]]);
    }

    public function incidentExists($id)
    {
        return checkForData($this->table_incident, [['incident_ID', '=', $id]]);
    }
}
