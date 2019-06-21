<?php

/**
 * Setting Model
 */
class SettingModel extends APP_Model
{
    public function get($name, $field = null)
    {
        $settings = $this->db->like("name", $name . ".")->get("settings");

        foreach ($settings->result() as $value) {
            $name = explode(".", $value->name);
            $data[$name[1]] = $value->value;
        }

        $parsed = @json_encode($data);
        $data = @json_decode($parsed);
        
        return ($field == null) ? $data : $data->$field;
    }

    public function set($name, array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->db->where("name", $name . "." . $key);
            $this->db->set("value", $value ? $value : null);
            $this->db->update("settings");
        }
    
        return $this->db->affected_rows() > 0 ? true : false;
    }
}
