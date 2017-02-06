<?php
/**
 * Created by PhpStorm.
 * User: fabsolutely
 * Date: 05/02/2017
 * Time: 19:39
 */

namespace Fabs\CouchDB2\Query\Queries;


use Fabs\CouchDB2\Query\DBQuery;
use Fabs\CouchDB2\Query\QueryMethods;
use Fabs\CouchDB2\Query\QueryStatusCodes;

class BulkDocsDBQuery extends DBQuery
{
    public function __construct($couch_object, $database_name)
    {
        $this->reset();
        parent::__construct($couch_object, $database_name);
        $this->execution_method = 'bulk_docs';
        $this->query_url = '_bulk_docs';
        $this->query_data = ['docs' => []];
        $this->query_method = QueryMethods::POST;
        $this->allowed_response_codes = [QueryStatusCodes::CREATED];
        return $this;
    }

    public function add_docs($docs)
    {
        foreach ($docs as $doc) {
            $this->query_data['docs'][] = (array)$doc;
        }
        return $this;
    }

    public function add_doc($doc)
    {
        $doc = (array)$doc;
        $this->query_data['docs'][] = $doc;
        return $this;
    }

    public function set_delayed_commit_policy($value)
    {
        if (is_bool($value)) {
            $this->query_headers['X-Couch-Full-Commit'] = $value;
        }
        return $this;
    }

    public function set_new_edits($value)
    {
        if (is_bool($value)) {
            $this->query_data['new_edits'] = $value;
        }
        return $this;
    }
}