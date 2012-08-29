<?php

class assaydepot {

    private $access_token;
    private $url;
    private $params;
    private $options;
    private $facets;
    private $json_query;

    /**
     * Set access token and url for api call, and create blank arrays
     * for class methods to use.
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
     * on $params array, which is created prior to calling this
     * method. This method returns a formatted URL to be used for
     * makign the API call.
     *
     * search($search_type, $query="") - combines all the pieces to build
     * the URL into an array and then uses search_url() to reutrn the
     * built URL string to use in json_output().
     *    $search_type acceptable inputs:
     *        1. 'wares'
     *        2. 'providers'
     *    $query: default set to "", and does not need to be set if
     *            the intention is to return all possible results.
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
     * get_url() - constructs URL for pulling information from Assay
     * Depot based. $params array is created prior to calling this
     * method and it's contents are used to build the url strign. This
     * method returns a formatted URL to be used for makign the API
     * call.
     *
     * get($search_type, $id, $query="") - combines all the pieces to build
     * the URL into an array and then uses search_url() to reutrn the
     * built URL string to use in json_output().
     *    $search_type acceptable inputs:
     *        1. 'wares'
     *        2. 'providers'
     *    $id: the id of the provider or ware to be returned
     *    $query: default set to "", and does not need to be set if
     *            the intention is to return all possible results.
     */
    private function get_url() {
        $format = '%s/%s/%s.json?';
        $format .= trim(str_repeat("%s=%s&", (count($this->params)-3)/2), "&");
        return vsprintf($format, $this->params);
    }

    public function get($search_type, $id, $query="") {
        array_push($this->params, $this->url, $search_type, $id, 'q', $query);
        $this->options_build();
        $this->facets_build();
        array_push($this->params, "access_token", $this->access_token);
        $this->json_query = $this->get_url();
    }

    /**
     * option_set() - specifies a value for one of 4 known options.
     *
     * option_unset() - removes the value previously set for an
     * option. When reusing a class, options must be manually unset if
     * you do not wish them to apply to the new api call. Options can
     * be set, without first calling unset for cases like pagination
     * and moving on to the next page of results.
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
     * set multiple times per URL with different facets
     *
     * facet_unset() - removes the key/value pair previously set for a
     * facet. When reusing a class, facets must be manually unset if
     * you do not wish them to apply to the new api call.
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
     * parses it to an associative array. Prior to returning the
     * result, the $params array is reset to an empty array to be
     * ready for the new api call. $options and $facets retain their
     * values and need to be manually unset prior to making another
     * api call if needed.
     */
    public function json_output() {
        if ($this->json_query != "") {
            $json = file_get_contents($this->json_query);
            $this->params = array();
            return json_decode($json, true);
        } else {
            die("Assay Depot Query URL is empty.");
        }
    }
}

?>