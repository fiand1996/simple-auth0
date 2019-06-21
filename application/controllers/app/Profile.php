<?php

class Profile extends APP_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->requireLogged();
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post("action") == "update") {
                $this->save();
            } elseif ($this->input->post("action") == "upload") {
                $this->upload();
            } elseif ($this->input->post("action") == "resend-email") {
                $this->resendVerificationEmail();
            }
        }

        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "siteTitle" => $this->userAuth->firstname . " " . $this->userAuth->lastname,
        ];

        $this->template->app("profile/index", $VIEW_DATA);
    }

    private function save()
    {
        $this->response->result = 0;
        $data_update = [];

        $required_fields = ["email", "firstname", "lastname"];

        foreach ($required_fields as $field) {
            if (!$this->input->post($field)) {
                $this->response->message = "Semua bidang wajib di isi!";
                $this->jsonecho();
            }
        }

        $email = strtolower($this->input->post("email"));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->response->message = "Email yang Anda masukkan tidak valid!";
            $this->jsonecho();
        }

        $u = $this->db->where("email", $email)->get("users");

        if (($u->num_rows() > 0) && $u->row("id") != $this->userAuth->id) {
            $this->response->message = "Email yang Anda masukkan tidak tersedia!";
            $this->jsonecho();
        }

        $email_changed = $email == $this->userAuth->email ? false : true;

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

        $data_update["firstname"] = $this->input->post("firstname");
        $data_update["lastname"] = $this->input->post("lastname");
        $data_update["email"] = $this->input->post("email");
        $data_update["app_theme"] = $this->input->post("app_theme");

        $app_layout = $this->input->post("app_layout") ? $this->input->post("app_layout") : [];

        $data_update["app_layout"] = implode(" ", $app_layout);

        $data_update["timezone"] = $this->input->post("timezone");

        if (!in_array($data_update["timezone"], DateTimeZone::listIdentifiers())) {
            $data_update["timezone"] = "UTC";
        }

        $valid_date_formats = [
            "Y-m-d", "d-m-Y", "d/m/Y", "m/d/Y",
            "d F Y", "F d, Y", "d M, Y", "M d, Y",
        ];

        $data_update["date_format"] = $this->input->post("date_format");

        if (!in_array($data_update["date_format"], $valid_date_formats)) {
            $data_update["date_format"] = $valid_date_formats[4];
        }

        $data_update["time_format"] = $this->input->post("time_format") == "24" ? "24" : "12";

        if (mb_strlen($this->input->post("password")) > 0) {
            $data_update["password"] = password_hash($this->input->post("password"), PASSWORD_DEFAULT);
        }

        if ($this->UserModel->update($this->userAuth->id, $data_update)) {
            if ($email_changed && $this->userAuth->account_type !== "admin") {
                $getUserByEmail = $this->db->where("email", strtolower($this->input->post("email")))->get("users");

                $this->load->library("mail");

                if (!$this->mail->sendNotification("activation", $getUserByEmail->row_array())) {
                    $this->UserModel->unsetCode($getUserByEmail->row("id"), "activation");
                }
            }

            sendAlert("Data berhasil disimpan!", "success");

            $this->response->result = 1;
            $this->response->redirect = base_url("profile");
            $this->jsonecho();
        }

        $this->response->message = "Terjadi kesalahan! Silahkan ulangi beberapa saat lagi.";
        $this->jsonecho();
    }

    private function upload()
    {
        $this->load->helper("string");
        $this->load->library("upload");

        $uniq_id = random_string("alnum", 25);

        $config["upload_path"] = FCPATH . "/media/users/";
        $config["allowed_types"] = "jpg|png";
        $config["file_name"] = $uniq_id;
        $config["max_size"] = 50000;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload("croppedImage")) {
            $this->response->result = 0;
            $this->response->message = $this->upload->display_errors();
            $this->jsonecho();
        }

        $upload = $this->upload->data();

        $this->load->library("image_lib");

        $config["image_library"] = "gd2";
        $config["source_image"] = $upload["full_path"];
        $config["maintain_ratio"] = true;
        $config["width"] = 200;
        $config["height"] = 200;
        $config["new_image"] = $upload["full_path"];

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        if ($this->userAuth->picture != "avatar.png" &&
            file_exists(FCPATH . "/media/users/" . $this->userAuth->picture)) {
            @unlink(FCPATH . "/media/users/" . $this->userAuth->picture);
        }

        $this->UserModel->update($this->userAuth->id, [
            "picture" => $upload["file_name"],
        ]);

        $this->response->result = 1;
        $this->response->message = "Foto profile berhasil diupdate";
        $this->response->img_url = base_url("media/users/" . $upload["file_name"]);
        $this->jsonecho();

    }

    private function resendVerificationEmail()
    {
        $this->response->result = 1;
        $this->response->message = "Tautan untuk verifikasi berhasil terkirim!";

        $getUserById = $this->db->where("id", $this->userAuth->id)->get("users");

        $this->load->library("mail");

        if (!$this->mail->sendNotification("activation", $getUserById->row_array())) {
            $this->response->result = 0;
            $this->response->message = "Tautan untuk verifikasi gagal terkirim!";
        }

        $this->jsonecho();
    }
}
