<?php

class Users extends APP_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->requireLogged();

        if (!$this->UserModel->isAdmin()) {
            show_404();
        }
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post("action") == "save") {
                $this->save();
            } else if ($this->input->post("action") == "remove") {
                $this->remove();
            }
        }

        $limit = (int) $this->input->get('limit') ? $this->input->get('limit') : 5;

        $start = ((int) $this->input->get('page')) ? ($this->input->get('page')) : 1;

        $offset = $limit * ($start - 1);

        $total = count($this->UserModel->queryTable([
            "like" => $this->input->get("q"),
            "where" => $this->input->get("group"),
        ]));

        $query = [
            "like" => $this->input->get("q"),
            "where" => $this->input->get("group"),
            "start" => $offset,
            "limit" => $limit,
        ];

        $results = $this->UserModel->queryTable($query);

        $to = $offset + $limit;
        $from = $offset + 1;

        if ($to > $total) {
            $to = $total;
        }

        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "Users" => $results,
            'currentPage' => $start,
            'form' => $from,
            'totalPages' => ceil($total / $limit),
            "siteTitle" => "Pengguna",
        ];
        $this->template->app("users/index", $VIEW_DATA);
    }

    public function add($id = null)
    {
        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "siteTitle" => "Tambah Pengguna",
        ];

        $this->template->app("users/add", $VIEW_DATA);
    }

    public function update($id = null)
    {
        $User = $this->UserModel->getById($id);

        if (!$User) {
            redirect('users');
        }

        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "User" => $User,
            "siteTitle" => $User->firstname . " " . $User->lastname,
        ];

        $this->template->app("users/update", $VIEW_DATA);
    }

    private function save()
    {
        $this->response->result = 0;
        $save_data = [];

        $is_new = !$this->input->post("id") ? true : false;

        $required_fields = ["email", "firstname", "lastname"];

        if ($is_new) {
            $required_fields[] = "password";
            $required_fields[] = "passconfirm";
        }

        foreach ($required_fields as $field) {
            if (!$this->input->post($field)) {
                $this->response->message = "Semua bidang wajib di isi!";
                $this->jsonecho();
            }
        }

        if (!filter_var($this->input->post("email"), FILTER_VALIDATE_EMAIL)) {
            $this->response->message = "Email yang Anda masukkan tidak valid!";
            $this->jsonecho();
        }

        $User = $this->db->where("email", $this->input->post("email"))->get("users");

        if (($User->num_rows() > 0) && $User->row("id") != $this->input->post("id")) {
            $this->response->message = "Email yang Anda masukkan tidak tersedia!";
            $this->jsonecho();
        }

        if (mb_strlen($this->input->post("password")) > 0) {
            if (mb_strlen($this->input->post("password")) < 6) {
                $this->response->message = "Password tidak boleh kurang dari 6 karakter!";
                $this->jsonecho();
            }

            if ($this->input->post("passconfirm") != $this->input->post("password")) {
                $this->response->message = "Konfirmasi password tidak sama dengan password!";
                $this->jsonecho();
            }
        }

        $save_data["firstname"] = $this->input->post("firstname");
        $save_data["lastname"] = $this->input->post("lastname");
        $save_data["email"] = $this->input->post("email");

        $save_data["app_theme"] = $this->input->post("app_theme") ?
        $this->input->post("app_theme") :
        "skin-blue";

        $app_layout = $this->input->post("app_layout") ?
        $this->input->post("app_layout") :
        [];

        $save_data["app_layout"] = implode(" ", $app_layout);

        $save_data["timezone"] = $this->input->post("timezone");

        if (!in_array($save_data["timezone"], DateTimeZone::listIdentifiers())) {
            $save_data["timezone"] = "UTC";
        }

        $valid_date_formats = [
            "Y-m-d", "d-m-Y", "d/m/Y", "m/d/Y",
            "d F Y", "F d, Y", "d M, Y", "M d, Y",
        ];

        $save_data["date_format"] = $this->input->post("date_format");

        if (!in_array($save_data["date_format"], $valid_date_formats)) {
            $save_data["date_format"] = $valid_date_formats[0];
        }

        $save_data["time_format"] = $this->input->post("time_format") == "24" ? "24" : "12";

        if (mb_strlen($this->input->post("password")) > 0) {
            $passhash = password_hash($this->input->post("password"), PASSWORD_DEFAULT);
            $save_data["password"] = $passhash;
        }

        if ($this->userAuth->id != $this->input->post("id")) {
            $valid_account_types = ["member", "admin", "developer"];
            $account_type = $this->input->post("account_type");

            if (!in_array($account_type, $valid_account_types)) {
                $account_type = "member";
            }

            $expire_date = new DateTime($this->input->post("expire_date"), new DateTimeZone($this->userAuth->timezone));
            $expire_date->setTimezone(new DateTimeZone(date_default_timezone_get()));

            $save_data["account_type"] = $account_type;
            $save_data["is_active"] = $this->input->post("status") == 1 ? 1 : 0;
            $save_data["expire_date"] = $expire_date->format("Y-m-d H:i:s");
        }

        if ($is_new) {
            $save = $this->UserModel->add($save_data);
            $this->response->redirect = base_url("users");
        } else {
            $save = $this->UserModel->update($this->input->post("id"), $save_data);
            $this->response->message = "Data Pengguna berhasil disimpan!";
        }

        if ($save) {
            $this->response->result = 1;
            $this->jsonecho();
        }

        $this->response->message = "Terjadi kesalahan! Silahkan ulangi beberapa saat lagi.";
        $this->jsonecho();
    }

    private function remove()
    {
        $ids = explode(",", $this->input->post("id"));

        foreach ($ids as $id) {

            $User = $this->UserModel->getById($id);

            if ($User && $this->userAuth->id != $User->id) {
                if ($User->picture != "avatar.png" &&
                    file_exists(FCPATH . "/media/users/" . $User->picture)) {
                    @unlink(FCPATH . "/media/users/" . $User->picture);
                }

                $this->UserModel->delete($User->id);
            }
        }

        $this->response->result = 1;
        $this->jsonecho();
    }
}
