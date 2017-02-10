<?php

/**
 * Created by PhpStorm.
 * User: fabsolutely
 * Date: 03/02/2017
 * Time: 07:07
 */
namespace Fabs\CouchDB2\Query;

abstract class QueryBase
{
    /**
     * @var \Fabs\CouchDB2\Couch
     */
    protected $couch_object;

    protected $query_url = '';
    protected $query_method = '';
    protected $query_data = [];
    protected $query_headers = [];
    protected $query_options = [];
    protected $query_parameters = [];
    protected $allowed_response_codes = [];

    public function __construct($couch_object)
    {
        $this->couch_object = $couch_object;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return $this->couch_object->execute($this);
    }

    /**
     * @return string
     */
    public function getQueryUrl()
    {
        $query = http_build_query($this->query_parameters, null, '&');
        if (strlen($query) > 0) {
            return sprintf('%s?%s', $this->query_url, $query);
        }
        return $this->query_url;
    }

    /**
     * @return string
     */
    public function getQueryMethod()
    {
        return $this->query_method;
    }

    /**
     * @return array
     */
    public function getQueryData()
    {
        if (count($this->query_data) > 0) {
            return json_encode($this->query_data);
        }
        return '';
    }

    /**
     * @return array
     */
    public function getQueryHeaders()
    {
        return $this->query_headers;
    }

    /**
     * @return array
     */
    public function getQueryOptions()
    {
        return $this->query_options;
    }

    /**
     * @return array
     */
    public function getAllowedResponseCodes()
    {
        return $this->allowed_response_codes;
    }

    protected function reset()
    {
        $this->query_url = '';
        $this->query_method = '';
        $this->query_data = [];
        $this->query_headers = [];
        $this->query_options = [];
        $this->query_parameters = [];
        $this->allowed_response_codes = [];
    }

    /**
     * @param $name
     * @param $args
     * @param null $filter
     * @return QueryBase
     */
    protected function setQueryParameters($name, $args, $filter = null)
    {

        switch ($filter) {
            case 'int':
                $this->query_parameters[$name] = (int)$args;
                break;
            case 'json_encode':
                $this->query_parameters[$name] = json_encode($args);
                break;
            case 'ensure_array':
                if (is_array($args)) {
                    $this->query_parameters[$name] = $args;
                }
                break;
            case 'string':
                $this->query_parameters[$name] = (string)$args;
                break;
            case 'json_encode_boolean':
                $this->query_parameters[$name] = json_encode((boolean)$args);
                break;
            default:
                $this->query_parameters[$name] = $args;
                break;
        }
        return $this;
    }
}