<?php 

/**
 * User Model
 */
class UserModel extends APP_Model
{
    public function queryTable($query = [])
    {
        $DB = $this->db;

        $DB->select("*");
        $DB->from("users");

        if (isset($query['like']) && 
            $query['like'] != null)  
        {
           $DB->like("firstname", $query['like']);
           $DB->or_like("lastname", $query['like']);
           $DB->or_like("email", $query['like']);
        }

        if (isset($query['where']) && 
            $query['where'] != 2 && 
            $query['where'] != null)  
        {
            $date = new DateTime("now");
            $curr_date = $date->format("Y-m-d H:i:s");
            $DB->where("DATE(expire_date) >", $curr_date);
            $DB->where("is_active", $query['where']);
        }

        if (isset($query['where']) && $query['where'] == 2)  
        {
            $date = new DateTime("now");
            $curr_date = $date->format("Y-m-d H:i:s");
            $DB->where("DATE(expire_date) <", $curr_date);
        } 

        if (isset($query['limit']) && isset($query['start'])) {
            $this->db->limit($query['limit'], $query['start']);
        }

        $DB->order_by("id", "DESC");

        return $DB->get()->result();
    }

    public function getAll($query = null)
    {
        $query = $this->db->select("*")
                          ->from("users")
                          ->order_by("id", "DESC")
                          ->get();

        return $query->result();
    }

    public function getById($id)
    {
        $query = $this->db->where("id", $id)
                         ->get("users");

        return $query->row();
    }

    public function getCode($hash, $type)
    {
        $partedHash = explode(".", $hash);
        
        if (count($partedHash) !== 2 ) 
        {
            return false;
        }

        $user = $this->db->where("id", $partedHash[1])
                         ->where("code_type", $type)
                         ->where("code", $partedHash[0])
                         ->get("users");

        if ($user->num_rows() !== 1) 
        {
            return false;
        }

        $timezone = new DateTimeZone($user->row("timezone"));
        $date = new DateTime(null, $timezone);
        $currentTime = strtotime($date->format('Y-m-d H:i:s'));

        if ($type == "recovery" && 
            $user->row("code_time") < ($currentTime - (2*60*60))) 
        {
            $this->unsetCode($user->row("id"), "recovery");
            return false;
        }

        return $user->row();
    }

    public function unsetCode($id, $type)
    {
        if ($type == "activation") 
        {
            $this->db->set("is_active", 1);
        }

        $this->db->set("code_type", null)
                 ->set("code_time", null)
                 ->set("code", null)
                 ->where("id", $id)
                 ->update("users");
    }

    public function getUserdata($field = null)
    {
        $decryptedID = $this->encryption->decrypt($this->session->userdata("SESSION_ID"));
        
        $User = $this->db->where("id", $decryptedID)
                         ->get('users');

        return ($field == null) ? $User->row() : $User->row($field);
    }

    public function add(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->db->set($key, $value);
        }
        $this->db->insert("users");

        return $this->db->affected_rows() > 0 ? true : false;
    }

    public function update($id, array $data = [])
    {
        foreach ($data as $field => $value) {
            $this->db->set($field, $value);
        }

        $this->db->where("id", $id);
        $this->db->update("users");

        return true;
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('users');
    }

    public function signin($email, $password, $remember)
    {
        $User = $this->db->where("email", $email)->get("users");

        if ($User->num_rows() == 1 &&
            password_verify($password, $User->row("password"))) 
        {
            $userdata = [
                "IS_LOGGED" => true,
                "ACCOUNT_TYPE" => $User->row("account_type"),
                "SESSION_ID"  => $this->encryption->encrypt($User->row("id"))
            ];

            if ($remember) 
            {
                $hash = $User->row("id") . "." . md5($User->row("password"));
                set_cookie("UID", $this->encryption->encrypt($hash), 1209600);
            }

            $this->session->set_userdata($userdata);
            return true;
        }

        return false;
    }

    public function isLogged()
    {
        if ($this->session->has_userdata("IS_LOGGED") &&
            $this->session->userdata("IS_LOGGED") == true) 
        {
            $decryptedID = $this->encryption->decrypt($this->session->userdata("SESSION_ID"));

            $User = $this->db->where("id", $decryptedID)->get("users");
            
            if ($User->num_rows() == 1)
            {
                return  true;
            }

            $this->session->unset_userdata(["IS_LOGGED", "SESSION_ID", "ACCOUNT_TYPE"]);
        }

        return false;
    }

    public function isAdmin()
    {
        if ($this->session->has_userdata("ACCOUNT_TYPE") &&
            $this->session->userdata("ACCOUNT_TYPE") == "admin") 
        {
            return true;
        }

        return false;
    }

    public function isExpire($id = null)
    {
        $id = isset($id) ? $id : $this->encryption->decrypt($this->session->userdata("SESSION_ID"));
        $User =$this->db->where("id", $id)->get("users");

        if ($User->num_rows() > 0) 
        {
            $ed = new DateTime($User->row("expire_date"));
            $now = new DateTime();
            if ($ed > $now) 
            {
                return false;
            }
        }
        
        return true;
    }
}