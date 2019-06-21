<?php

class APP_Controller extends CI_Controller
{
    protected $userAuth;
    protected $settingGeneral;
    protected $response;
    protected $IpInfo;

    public function __construct()
    {
        parent::__construct();

        $this->response = new stdClass;

        $this->load->model("UserModel");
        $this->load->model("SettingModel");

        $this->saveSessionCookie();
        $this->userAuth = $this->UserModel->getUserdata();
        $this->IpInfo = $this->getIpInfo();

        if ($this->session->has_userdata("settingGeneral")) {
            $this->settingGeneral = $this->session->userdata("settingGeneral");
        } else {
            $this->session->set_userdata("settingGeneral", $this->SettingModel->get("general"));
            $this->settingGeneral = $this->session->userdata("settingGeneral");
        }
    }

    protected function requireLogged()
    {
        if (!$this->UserModel->isLogged()) {
            if ($this->input->is_ajax_request()) {
                $this->response->result = 0;
                $this->response->message = "Pengguna tidak diotorisasi";
                $this->jsonecho();
            } else {
                sendAlert("Anda harus masuk terlebih dahulu!", "danger");
                redirect("/signin?redirect=" . urlencode(uri_string()));
            }
        }
    }

    private function saveSessionCookie()
    {
        if (!$this->session->has_userdata("SESSION_ID") && get_cookie("UID")) {
            $cookieLogin = $this->encryption->decrypt(get_cookie("UID"));

            if ($cookieLogin) {
                $partedHash = explode(".", $cookieLogin);

                if (count($partedHash) == 2) {
                    $User = $this->db->where("id", $partedHash[0])->get("users");

                    if ($User->num_rows() == 1 &&
                        $User->row("is_active") == 1 &&
                        md5($User->row("password")) == $partedHash[1]) {
                        $userdata = [
                            "IS_LOGGED" => true,
                            "ACCOUNT_TYPE" => $User->row("account_type"),
                            "SESSION_ID" => $this->encryption->encrypt($User->row("id")),
                        ];

                        $this->session->set_userdata($userdata);
                    }
                }
            } else {
                delete_cookie("UID");
            }
        }
    }

    private function getIpInfo()
    {
        $client = empty($_SERVER['HTTP_CLIENT_IP']) ? null : $_SERVER['HTTP_CLIENT_IP'];
        $forward = empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? null : $_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = empty($_SERVER['REMOTE_ADDR']) ? null : $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } else if (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        if (!isset($_SESSION[$ip])) {
            $res = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip), true);

            $ipinfo = [
                "request" => "",
                "status" => "",
                "credit" => "",
                "city" => "",
                "region" => "",
                "areaCode" => "",
                "dmaCode" => "",
                "countryCode" => "",
                "countryName" => "",
                "continentCode" => "",
                "latitude" => "",
                "longitude" => "",
                "regionCode" => "",
                "regionName" => "",
                "currencyCode" => "",
                "currencySymbol" => "",
                "currencySymbol_UTF8" => "",
                "currencyConverter" => "",
                "timezone" => "",
                "neighbours" => [],
                "languages" => [],
            ];

            if (is_array($res)) {
                foreach ($res as $key => $value) {
                    $key = explode("_", $key, 2);
                    if (isset($key[1])) {
                        $ipinfo[$key[1]] = $value;
                    }
                }
            }

            if ($ipinfo["latitude"] && $ipinfo["longitude"]) {
                $username = null;

                if ($username) {
                    if (!empty($ipinfo["latitude"]) && !empty($ipinfo["longitude"])) {
                        $res = @json_decode(file_get_contents("http://api.geonames.org/timezoneJSON?lat=" . $ipinfo["latitude"] . "&lng=" . $ipinfo["longitude"] . "&username=" . $username));

                        if (isset($res->timezoneId)) {
                            $ipinfo["timezone"] = $res->timezoneId;
                        }
                    }

                    if (!empty($ipinfo["countryCode"])) {
                        $res = @json_decode(file_get_contents("http://api.geonames.org/neighboursJSON?country=" . $ipinfo["countryCode"] . "&username=" . $username));

                        if (!empty($res->geonames)) {
                            foreach ($res->geonames as $r) {
                                $ipinfo["neighbours"][] = $r->countryCode;
                            }
                        }
                    }

                    if (!empty($ipinfo["countryCode"])) {
                        $res = @json_decode(file_get_contents("http://api.geonames.org/countryInfoJSON?country=" . $ipinfo["countryCode"] . "&username=" . $username));

                        if (!empty($res->geonames[0]->languages)) {
                            $langs = explode(",", $res->geonames[0]->languages);
                            foreach ($langs as $l) {
                                $ipinfo["languages"][] = $l;
                            }
                        }
                    }
                }
            }

            $_SESSION[$ip] = $ipinfo;
        }

        return json_decode(json_encode($_SESSION[$ip]));
    }

    protected function jsonecho($response = null)
    {
        if (is_null($response)) {
            $response = $this->response;
        }
        header('Content-Type: application/json; charset=utf-8');
        echo $this->input->get("callback") ?
        $this->input->get("callback") . "(" . json_encode($response) . ")" :
        json_encode($response);
        exit;
    }
}
