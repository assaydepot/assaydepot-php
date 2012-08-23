<?php

class AssayDepot {

    private $access_token;
    private $url;
    private $params;
    private $options;

    private function __construct($access_token, $url) {
        $this->access_token = $access_token;
        $this->url = $url;
        $this->params = array();
        $this->options = array("page" => "",
                               "per_page" => "",
                               "sort_by" => "",
                               "sort_order" => "");
    }

    function search_url() {
        $format = '%s/%s.json?';
        $format = trim(str_repeat("%s=%s&", count($this->params)-2), "&");
        return vsprintf($format, $this->params);
    }

    function get_url() {
        $format = '%s/%s/%s.json?';
        $format = trim(str_repeat("%s=%s&", count($this->params)-3), "&");
        return vsprintf($format, $this->params);
    }

    function search($search_type, $query, $facets) {
        array_push($this->params, $this->url, $search_type, 'q', $query);
        options_build();
        //sort out facets here
        array_push($this->params, "access_token", $this->$access_token);
    }

    function get($search_type, $query, $id, $facets) {
        array_push($this->params, $this->url, $search_type, $id, 'q', $query);
        options_build();
        //sort out facets here
        array_push($this->params, "access_token", $this->$access_token);
    }

    public function options_set($page=1, $per_page=25, $sort_by="", $sort_order="desc") {
        if ($page != 1) {
            $this->options["page"] = $page;
        }
        if ($per_page != 25) {
            $this->options["per_page"] = $per_page;
        }
        if ($sort_by != "") {
            $this->options["sort_by"] = $sort_by;
        }
        if ($sort_order != "desc") {
            $this->options["sort_order"] = $sort_order;
        }
    }

    private function options_build() {
        foreach ($this->options as $k=>$v) {
            switch ($k) {
                case "page":
                    if ($v != "") {
                        array_push($this->params, $k, $v);
                    }
                    break;
                case "per_page":
                    if ($v != "") {
                        array_push($this->params, $k, $v);
                    }
                    break;
                case "sort_by":
                    if ($v != "") {
                        array_push($this->params, $k, $v);
                    }
                    break;
                case "sort_order":
                    if ($v != "") {
                        array_push($this->params, $k, $v);
                    }
                    break;
            }
        }
    }

}

?>