<?php

/**
 * Email Class
 *
 * @package     CodeIgniter
 * @category    Library
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

use PHPMailer\PHPMailer\PHPMailer;

class Mail extends PHPMailer
{
    private $template;

    private $emailSettings;

    private $siteSettings;

    public function __get($var)
    {
        return get_instance()->$var;
    }

    public function __construct()
    {
        parent::__construct();

        $emailSettings = $this->getEmailSettings();
        $siteSettings = $this->getSiteSettings();

        $this->SMTPDebug = 0;
        $this->CharSet = "UTF-8";
        $this->isHTML();

        if ($emailSettings->host) {
            $this->isSMTP();

            if ($emailSettings->from) {
                $this->From = $emailSettings->from;
                $this->FromName = htmlchars($siteSettings->site_name);
            }

            $this->Host = $emailSettings->host;
            $this->Port = $emailSettings->port;
            $this->SMTPSecure = $emailSettings->encryption;

            if ($emailSettings->auth) {
                $this->SMTPAuth = true;
                $this->Username = $emailSettings->username;
                $this->Password = $emailSettings->password;

            }

            // $this->SMTPOptions = array(
            //     'ssl' => array(
            //         'verify_peer' => false,
            //         'verify_peer_name' => false,
            //         'allow_self_signed' => true
            //     )
            // );
        }
    }

    public function sendmail($content)
    {
        $html = $this->getTemplate();
        $html = str_replace("{{email_content}}", $content, $html);

        $this->Body = $html;

        return $this->send();
    }

    private function getEmailSettings()
    {
        if (is_null($this->emailSettings)) {
            $this->emailSettings = $this->SettingModel->get("email");
        }

        return $this->emailSettings;
    }

    private function getSiteSettings()
    {
        if (is_null($this->siteSettings)) {
            $this->siteSettings = $this->SettingModel->get("general");
        }

        return $this->siteSettings;
    }

    private function getTemplate()
    {
        if (!$this->template) {
            $html = file_get_contents(APPPATH . "views/email_template.php");
            $siteSettings = $this->getSiteSettings();

            $html = str_replace(
                [
                    "{{site_name}}",
                    "{{foot_note}}",
                    "{{appurl}}",
                    "{{copyright}}",
                ],
                [
                    htmlchars($siteSettings->site_name),
                    __("Terima kasih telah menggunakan %s.", htmlchars($siteSettings->site_name)),
                    APPURL,
                    __("All rights reserved."),
                ],
                $html
            );

            $this->template = $html;
        }

        return $this->template;
    }

    public function sendNotification($type = "new-user", $data = [])
    {
        switch ($type) {
            case "activation":
                return $this->sendActivationEmail($data);
                break;

            case "recovery":
                return $this->sendPasswordRecovery($data);
                break;

            default:
                break;
        }
    }

    public function sendTestEmail($data = [])
    {
        $siteSettings = $this->getSiteSettings();

        $mail = new Mail;

        $mail->Subject = "Test Email";

        $mail->addAddress($data['email']);

        $emailbody = "<p>Konfigurasi Anda sudah benar!</p>";

        return $mail->sendmail($emailbody);
    }

    private function sendActivationEmail($data = [])
    {
        $siteSettings = $this->getSiteSettings();

        $mail = new Mail;
        $mail->Subject = "Verifikasi Akun";

        $timezone = new DateTimeZone($data['timezone']);
        $date = new DateTime(null, $timezone);
        $currentTime = strtotime($date->format('Y-m-d H:i:s'));

        $this->load->helper("string");
        $hash = random_string("alnum", 80);

        if (isset($data['code']) && $data['code_type'] == "activation") {
            $hash = $data['code'];
        }

        $this->db->set("is_active", 0)
            ->set("code_type", "activation")
            ->set("code_time", $currentTime)
            ->set("code", $hash)
            ->where("id", $data['id'])
            ->update("users");

        $mail->addAddress($data['email']);

        $emailbody = "<p>" . __("Halo %s", htmlchars($data['firstname'])) . ", </p>"
        . "<p>" . __("Harap verifikasi alamat email %s milik Anda. Untuk melakukannya, cukup klik tombol di bawah ini.", "<strong>" . htmlchars($data['email']) . "</strong>")
        . "<div style='margin-top: 30px; font-size: 14px; color: #9b9b9b'>"
        . "<a style='display: inline-block; background-color: #3b7cff; color: #fff; font-size: 14px; line-height: 24px; text-decoration: none; padding: 6px 12px; border-radius: 4px;' href='" . base_url() . "activation/" . $hash . "." . $data['id'] . "'>" . __("Verifikasi Email") . "</a>"
            . "</div>";

        return $mail->sendmail($emailbody);
    }

    private function sendPasswordRecovery($data = [])
    {
        $siteSettings = $this->getSiteSettings();

        $mail = new Mail;
        $mail->Subject = "Reset Password";

        $timezone = new DateTimeZone($data['timezone']);
        $date = new DateTime(null, $timezone);
        $currentTime = strtotime($date->format('Y-m-d H:i:s'));

        $this->load->helper("string");
        $hash = random_string("alnum", 80);

        if (isset($data['code']) && $data['code_type'] == "recovery") {
            $hash = $data['code'];
        }

        $this->db->set("code_type", "recovery")
            ->set("code_time", $currentTime)
            ->set("code", $hash)
            ->where("id", $data['id'])
            ->update("users");

        $mail->addAddress($data['email']);

        $emailbody = "<p>" . __("Halo %s", htmlchars($data['firstname'])) . ", </p>"
        . "<p>" . __("Seseorang meminta pengaturan ulang kata sandi untuk akun Anda di %s. Jika ini Anda, klik tombol di bawah ini untuk mendapatkan kata sandi baru. Jika bukan, Anda bisa mengabaikan email ini. Akun Anda masih aman. Link akan kadaluwarsa setelah 2 jam.", "<a href='" . base_url() . "'>" . htmlchars($siteSettings->site_name) . "</a>") . "</p>"
        . "<div style='margin-top: 30px; font-size: 14px; color: #9b9b9b'>"
        . "<a style='display: inline-block; background-color: #3b7cff; color: #fff; font-size: 14px; line-height: 24px; text-decoration: none; padding: 6px 12px; border-radius: 4px;' href='" . base_url() . "reset/" . $hash . "." . $data['id'] . "'>" . __("Reset Password") . "</a>"
            . "</div>";

        return $mail->sendmail($emailbody);
    }
}
