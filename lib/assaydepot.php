<?php

class AssayDepot {

    private $access_token;
    private $url;
    private $params;
    private $options;
    private $facets;
    private $json_query;

    private function __construct($access_token, $url) {
        $this->access_token = $access_token;
        $this->url = $url;
        $this->params = array();
        $this->options = array("page" => "",
                               "per_page" => "",
                               "sort_by" => "",
                               "sort_order" => "");
    }

    private function search_url() {
        $format = '%s/%s.json?';
        $format = trim(str_repeat("%s=%s&", count($this->params)-2), "&");
        return vsprintf($format, $this->params);
    }

    public function search($search_type, $query, $facets) {
        array_push($this->params, $this->url, $search_type, 'q', $query);
        options_build();
        facets_build();
        array_push($this->params, "access_token", $this->$access_token);
        $this->json_query = search_url();
    }

    private function get_url() {
        $format = '%s/%s/%s.json?';
        $format = trim(str_repeat("%s=%s&", count($this->params)-3), "&");
        return vsprintf($format, $this->params);
    }

    public function get($search_type, $query, $id, $facets) {
        array_push($this->params, $this->url, $search_type, $id, 'q', $query);
        options_build();
        facets_build();
        array_push($this->params, "access_token", $this->$access_token);
        $this->json_query = get_url();
    }

    public function option_set($option, $value) {
        $known_options = array("page", "per_page", "sort_by", "sort_order");
        if ($option != "" && $value != "") {
            if (in_array($option, $known_options)) {
                $this->options[$option] = $value;
            }
        }
    }

    public function option_unset($option) {
        $known_options = array("page", "per_page", "sort_by", "sort_order");
        if (array_key_exists($option, $this->options)) {
            if (in_array($option, $known_options)) {
                $this->options[$option] = "";
            }
        }
    }

    private function options_build() {
        foreach ($this->options as $k=>$v) {
            array_push($this->params, $k, $v)
        }
    }

    public function facet_set($facet, $value) {
        if ($facet != "" && $value != "") {
            $this->facets[$facet] = $value;
        }
    }

    public function facet_unset($facet) {
        if (array_key_exists($facet, $this->facets)) {
            unset($this->facets[$facet]);
        }
    }

    private function facets_build() {
        foreach ($this->facets as $k=>$v) {
            array_push($this->params, "facets[".$k."][]", $v);
        }
    }

    public function json_output() {
        if ($this->json_query != "") {
            $json = get_file_contents($this-json_query);
            return json_decode($json);
        } else {
            die("Assay Depot Query URL is empty.");
        }
    }
}

?>