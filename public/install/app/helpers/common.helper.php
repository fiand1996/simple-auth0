<?php

    function create_database($data)
    {
        $mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');

        if(mysqli_connect_errno())
            return false;

        $mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);

        $mysqli->close();

        return true;
    }

    function create_tables($data)
    {
        
        $mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);

        if(mysqli_connect_errno())
            return false;

        $query = file_get_contents(INSTALLPATH . 'app/includes/install.sql');

        $mysqli->multi_query($query);

        $mysqli->close();

        return true;
    }

    function write_config($data) {

        $template_path  = INSTALLPATH . 'app/template/database.php';
        $output_path    = ROOTPATH . 'app/config/database.php';
        $index_path = PUBLICPATH . 'index.php';
        
        $index_file    = file_get_contents($index_path);
        $database_file = file_get_contents($template_path);

        $new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
        $new  = str_replace("%USERNAME%",$data['username'],$new);
        $new  = str_replace("%PASSWORD%",$data['password'],$new);
        $new  = str_replace("%DATABASE%",$data['database'],$new);

        $handle = fopen($output_path,'w+');

        @chmod($output_path,0777);

        if(is_writable($output_path)) {

            if(fwrite($handle,$new)) {
                $old_text = "define('ENVIRONMENT', 'installation');";
                $new_text = "define('ENVIRONMENT', 'production');";
                
                $new_index = str_replace($old_text, $new_text, $index_file);
                $handle_index = fopen($index_path,'w+');
                @chmod($index_path,0777);
                fwrite($handle_index,$new_index);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function jsonecho($status, $message = null)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status' => $status,
            'message' => $message
        ]);
        exit;
    }

    function delete($path = INSTALLPATH)
    {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }