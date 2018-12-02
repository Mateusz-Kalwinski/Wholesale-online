<?php
require_once 'Database.php';

class Information extends Database {
    public function infoLicense($options = array())
    {
        $nipConfig = "SELECT `value` FROM `config` WHERE `id` = '9'";
        $nip = $this->query($nipConfig);

        $url = 'api.api.pl/api/information.php';
        $post = [
            'nip' => $nip[0]['value']
        ];


        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => http_build_query($post)
        );

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if( !$result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);
        //zwraca nip, licencse i date z bazy danych api
        return json_decode($result,true);
    }
    public function infoDetails($options = array()){

        $url = 'api.api.pl/api/details.php';
        $post = [
            'id' => '1'
        ];


        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => http_build_query($post)
        );

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if( !$result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);
        //zwraca nip, licencse i date z bazy danych api

        $encodeDetails = json_decode($result,true);
        $explodeDetails = explode('/', $encodeDetails['information']);

        return $explodeDetails;
    }
}

