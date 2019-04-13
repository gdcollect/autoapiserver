<?php

namespace AutoApiServer\Api\ApiServer\Auto;

use AutoApiServer\Api\Auto\ApiAutoModel;

class ApiAutoService
{

    public function queryBuilder($requestBody, $requestType)
    {
        switch ($requestType) {
            case "GET":
                return $this->getQueryBuilder($requestBody);
                break;
            case "POST":
                return $this->postQueryBuilder($requestBody);
                break;
            case "UPDATE":
                return $this->updateQueryBuilder($requestBody);
                break;
            case "DELETE":
                return $this->deleteQueryBuilder($requestBody);
                break;
        }
    }

    private function getQueryBuilder($request)
    {
        $query = (new ApiAutoModel());
        if (array_key_exists('select', $request)) {
            $query = $query->select($request['select']);
        }
        if (array_key_exists('where', $request)) {
            $query = $this->where($query, $request['where']);
        }
        if (array_key_exists('whereIn', $request)) {
            $query = $this->whereIn($query, $request['whereIn']);
        }
        return $query->get();
    }

    private function postQueryBuilder(array $request)
    {
        $query = (new ApiAutoModel());
        $query->fill($request['data']);
        return $query->save();
    }

    private function updateQueryBuilder(array $request)
    {
        $query = (new ApiAutoModel());
        if (array_key_exists('where', $request)) {
            $query = $this->where($query, $request['where']);
        }
        if (array_key_exists('whereIn', $request)) {
            $query = $this->whereIn($query, $request['whereIn']);
        }
        return $query->update($request['data']);
    }

    private function deleteQueryBuilder(array $request)
    {
        $query = (new ApiAutoModel());
        if (array_key_exists('where', $request)) {
            $query = $this->where($query, $request['where']);
        }
        if (array_key_exists('whereIn', $request)) {
            $query = $this->whereIn($query, $request['whereIn']);
        }
        return $query->delete();
    }

    private function where($query, $clauses)
    {
        foreach ($clauses as $clause) {
            $clauseSize = count($clause);
            if (
                $clauseSize == 1 &&
                array_key_exists(0, $clause)
            ) {
                $query = $query->where('id', $clause);
            } elseif ($clauseSize > 1 && $clauseSize < 4) {
                if ($clauseSize == 2) {
                    $query = $query->where($clause[0], $clause[1]);
                } else {
                    $query = $query->where($clause[0], $clause[1], $clause[2]);
                }
            } else {
                throw new \Exception('Bad Request');
            }
        }
        return $query;
    }

    private function whereIn($query, $clauses)
    {
        foreach ($clauses as $clauseKey => $clauseValue) {
            if (
                is_string($clauseKey) &&
                is_array($clauseValue) &&
                count($clauseValue) > 0
            ) {
                $query = $query->whereIn($clauseKey, $clauseValue);
            } else {
                throw new \Exception('Bad Request');
            }
        }
        return $query;
    }
}
