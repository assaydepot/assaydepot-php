<?php

class assaydepot {

    private $access_token;
    private $url;
    private $params;
    private $options;
    private $facets;
    private $json_query;

    /**
     * Set private variables to be used throughout class
     */
    function __construct($access_token, $url) {
        $this->access_token = $access_token;
        $this->url = $url;
        $this->params = array();
        $this->facets = array();
        $this->options = array();
    }

    /**
     * search_url() - constructs URL for searching Assay Depot based
     * on $params array
     *
     * search() - combines all the pieces to build the URL into an
     * array and then uses search_url() to reutrn the built URL string
     * to pass into json_output().
     */
    private function search_url() {
        $format = '%s/%s.json?';
        $format .= trim(str_repeat("%s=%s&", (count($this->params)-2)/2), "&");
        return vsprintf($format, $this->params);
    }

    public function search($search_type, $query="") {
        array_push($this->params, $this->url, $search_type, 'q', $query);
        $this->options_build();
        $this->facets_build();
        array_push($this->params, "access_token", $this->access_token);
        $this->json_query = $this->search_url();
    }

    /**
     * get_url() - similar functionality to search_url() with an extra
     * paramater
     *
     * get() - similar functionality to search(), the difference being
     * the information returned.
     */
    private function get_url() {
        $format = '%s/%s/%s.json?';
        $format .= trim(str_repeat("%s=%s&", (count($this->params)-3)/2), "&");
        return vsprintf($format, $this->params);
    }

    public function get($search_type, $query="", $id) {
        array_push($this->params, $this->url, $search_type, $id, 'q', $query);
        $this->options_build();
        $this->facets_build();
        array_push($this->params, "access_token", $this->access_token);
        $this->json_query = $this->get_url();
    }

    /**
     * option_set() - specifies a value for one of 4 known options.
     *
     * option_unset() - removes the value previously set for an option
     *
     * options_build() - takes the set options and adds them to
     * $params, which is used to build the URL strings
     */
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
                unset($this->options[$option]);
            }
        }
    }

    private function options_build() {
        foreach ($this->options as $k=>$v) {
            array_push($this->params, $k, $v);
        }
    }

    /**
     * facet_set() - specifies a key/value pair for a facet. Can be
     * set multiple times per URL.
     *
     * facet_unset() - removes the key/value pair previously set for a
     * facet
     *
     * facets_build() - takes the set facets and adds them to
     * $params, which is used to build the URL strings
     */
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

    /**
     * json_output() - takes the URL string built through get() or
     * search(), fetches the json string returned by the API, and then
     * parses it to an associative array.
     */
    public function json_output() {
        if ($this->json_query != "") {
            $json = file_get_contents($this->json_query);
            return json_decode($json, true);
        } else {
            die("Assay Depot Query URL is empty.");
        }
    }
}

?>