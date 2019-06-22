<?php

if (!function_exists('getTimezones')) {
    function getTimezones()
    {
        $timezoneIdentifiers = DateTimeZone::listIdentifiers();
        $utcTime = new DateTime('now', new DateTimeZone('UTC'));

        $tempTimezones = array();
        foreach ($timezoneIdentifiers as $timezoneIdentifier) {
            $currentTimezone = new DateTimeZone($timezoneIdentifier);

            $tempTimezones[] = array(
                'offset' => (int) $currentTimezone->getOffset($utcTime),
                'identifier' => $timezoneIdentifier,
            );
        }

        usort($tempTimezones, function ($a, $b) {
            return ($a['offset'] == $b['offset'])
            ? strcmp($a['identifier'], $b['identifier'])
            : $a['offset'] - $b['offset'];
        });

        $timezoneList = array();
        foreach ($tempTimezones as $tz) {
            $sign = ($tz['offset'] > 0) ? '+' : '-';
            $offset = gmdate('H:i', abs($tz['offset']));
            $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .
                $tz['identifier'];
        }

        return $timezoneList;
    }

}

if (!function_exists('outputJSON')) {
    function outputJSON(array $data = [], $statusCode = 200)
    {
        $app = &get_instance();

        $parsed = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $app->output->set_status_header($statusCode)
            ->set_content_type('application/json', 'utf-8')
            ->set_output($parsed)
            ->_display();
        exit;
    }
}

if (!function_exists('readableRandomString')) {
    function readableRandomString($length = 6)
    {
        $string = '';
        $vowels = array("a", "e", "i", "o", "u");
        $consonants = array(
            'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
            'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z',
        );
        // Seed it
        srand((double) microtime() * 1000000);
        $max = $length / 2;
        for ($i = 1; $i <= $max; $i++) {
            $string .= $consonants[rand(0, 19)];
            $string .= $vowels[rand(0, 4)];
        }
        return $string;
    }
}

if (!function_exists('htmlchars')) {
    function htmlchars($string = "")
    {
        return htmlspecialchars($string, ENT_QUOTES, "UTF-8");
    }
}

if (!function_exists('__')) {
    function __($format, $num = null)
    {
        return sprintf($format, $num);
    }
}

if (!function_exists('textInitials')) {
    function textInitials($text, $length = 1)
    {
        $text = (string) $text;
        $length = (int) $length;

        if (mb_strlen($text) < $length || $length < 1) {
            return $text;
        }

        $parts = explode(" ", $text);
        foreach ($parts as &$p) {
            if (trim($p) == "") {
                unset($p);
            }
        }

        if (count($parts) >= $length) {
            $res = "";
            for ($i = 0; $i < $length; $i++) {
                $res .= mb_substr($parts[$i], 0, 1);
            }
        } else {
            if ($length == 1) {
                $res = mb_substr($text, 0, 1);
            } else if ($length == 2) {
                $res = mb_substr($text, 0, 1) . mb_substr($text, -1, 1);
            } else {
                $res = mb_substr($text, 0, $length);
            }
        }

        return $res;
    }
}

if (!function_exists('activeLeftMenu')) {
    function activeLeftMenu($path)
    {
        $app = &get_instance();
        return ($app->uri->segment(1) == $path) ? 'active' : '';
    }
}

if (!function_exists('slitName')) {
    function slitName($name)
    {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
        return array($first_name, $last_name);
    }
}

if (!function_exists('sendAlert')) {
    function sendAlert($msg, $type = 'success')
    {
        $app = &get_instance();

        return $app->session->set_flashdata('alert', [
            'msg' => $msg,
            'type' => $type
        ]);
    }
}

if (!function_exists('showAlert')) {
    function showAlert()
    {
        $app = &get_instance();

        $alert = $app->session->flashdata('alert');

        if ($alert) {
            return '<div class="alert alert-'.$alert['type'].'" role="alert">' . $alert['msg'] . '</div>';
        }

        return;
    }
}

if (!function_exists('sanitize_output')) {
    function sanitize_output($buffer)
    {
        $search = array(
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '/<!--(.|\s)*?-->/',
        );
        $replace = array(
            '>',
            '<',
            '\\1',
            '',
        );
        $buffer = preg_replace($search, $replace, $buffer);

        return $buffer;
    }
}
