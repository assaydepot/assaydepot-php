<?php

class AssayDepot {

    private $access_token;
    private $url;

    private function __construct($access_token, $url) {
        $this->access_token = $access_token;
        $this->url = $url;
    }

    function search_url($params) {
        $format = '%s/%s.json?';
        $format = trim(str_repeat("%s=%s&", count($params)-2), "&");
        return vsprintf($format, $params);
    }

    function get_url($params) {
        $format = '%s/%s/%s.json?';
        $format = trim(str_repeat("%s=%s&", count($params)-3), "&");
        return vsprintf($format, $params);
    }

    function search($search_type, $query, $facets) {
        $params = array($this->url, $search_type, 'q', $query);
        //sort out facets here
        array_push($params, "access_token", $this->$access_token);
    }

    function get($search_type, $query, $id, $facets) {
        $params = array($this->url, $search_type, $id, 'q', $query);
        //sort out facets here
        array_push($params, "access_token", $this->$access_token);
    }

}

?>