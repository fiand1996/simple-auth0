<?php

class Template
{
    public function __get($var)
    {
        return get_instance()->$var;
    }

    public function site($content, $data = null)
    {
        $html = [
            'head' => $this->load->view('site/fragments/head', $data, true),
            'header' => $this->load->view('site/fragments/header', $data, true),
            'content' => $this->load->view('site/' . $content, $data, true),
            'footer' => $this->load->view('site/fragments/footer', $data, true),
            'script' => $this->load->view('site/fragments/script', $data, true),
        ];

        return $this->load->view('site/fragments/template', $html);
    }

    public function app($content, $data = null, $component = null)
    {
        $html = [
            'head' => $this->load->view('app/fragments/head', $data, true),
            'topmenu' => $this->load->view('app/fragments/topmenu', $data, true),
            'leftmenu' => $this->load->view('app/fragments/leftmenu', $data, true),
            'content' => $this->load->view('app/' . $content, $data, true),
            'footer' => $this->load->view('app/fragments/footer', $data, true),
            'script' => $this->load->view('app/fragments/script', $data, true),
        ];

        if (isset($component)) {
            $html['component'] = $this->load->view('app/fragments/components/' . $component, $data, true);
        }

        return $this->load->view('app/fragments/template', $html);
    }

    public function auth($content, $data = null)
    {
        $html = [
            'content' => $this->load->view('auth/' . $content, $data, true),
        ];

        return $this->load->view('auth/fragments/template', $html);
    }
}
