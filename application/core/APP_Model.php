<?php

class APP_Model extends CI_Model
{
    protected $data;
    protected $is_available;

    public function __construct()
    {
        $this->data = array();
        $this->is_available = false;
    }

    public function isAvailable()
    {
        return $this->is_available;
    }

    public function markAsAvailable()
    {
        $this->is_available = true;
        return $this;
    }

    public function setEntry($field, $value, $parse = true)
    {
        if (is_string($field) && $field) {
            if ($parse) {
                $fields = explode(".", $field);
            }

            if (!empty($fields) && count($fields) > 1) {
                $column = $fields[0];

                array_shift($fields);
                $total = count($fields);

                $newval = $value;
                for ($i = $total - 1; $i >= 0; $i--) {
                    $newval = array($fields[$i] => $newval);
                }

                $currentval = json_decode($this->get($column), true);
                if (!$currentval) {
                    $currentval = array();
                }

                $this->data[$column] = json_encode(array_replace_recursive($currentval, $newval));
            } else {
                $this->data[$field] = $value;
            }
        }

        return $this;
    }

    public function get($field, $parse = true)
    {
        if (is_string($field) && $field) {
            if ($parse) {
                $fields = explode(".", $field);
            }

            if (!empty($fields) && count($fields) > 1) {
                $column = $fields[0];

                if (isset($this->data[$column]) && is_string($column) && $column) {
                    $parsedjson = @json_decode($this->data[$column]);

                    if ($parsedjson) {
                        array_shift($fields);

                        $val = $parsedjson;
                        foreach ($fields as $name) {
                            if ($name && isset($val->$name)) {
                                $val = $val->$name;
                            } else {
                                $val = null;
                                break;
                            }
                        }

                        return is_string($val) ? trim($val) : $val;
                    }
                }
            } else {
                if (isset($this->data[$field])) {
                    return is_string($this->data[$field]) ? trim($this->data[$field]) : $this->data[$field];
                }
            }
        }

        return null;
    }

    public function select($uniqid)
    {
        return $this;
    }

    public function extendDefaults()
    {
        return $this;
    }

    public function insert()
    {
        return $this;
    }

    public function updateEntry()
    {
        return $this;
    }

    public function save()
    {
        return $this->isAvailable() ? $this->update() : $this->insert();
    }

    public function deleteEntry()
    {
        return $this;
    }

    public function remove()
    {
        return $this->delete();
    }

    public function refresh()
    {
        $this->select($this->get("id"));
        return $this;
    }
}
