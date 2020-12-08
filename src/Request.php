<?php

namespace MyTest;

use MyTest\IRequest;

/**
 * @property string $requestMethod
 * @property string $queryString
 * @property string $serverProtocol
 * @property string $requestUri
 * 
 */
class Request implements IRequest
{
    public function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {
        foreach ($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase($string)
    {
        $result = strtolower($string);
        
        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    public function getBody()
    {
        if ($this->requestMethod === "GET") {
            return;
        }


        if ($this->requestMethod == "POST") {
            $body = array();
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            return $body;
        }
    }
    public function getQueryString(string $key): string
    {
        $allQueriesArray = explode('&', $this->queryString);
        foreach ($allQueriesArray as $singleQuery) {
            $splitQExpressionArray = explode('=', $singleQuery);
            if ($splitQExpressionArray[0] === $key) {
                return $splitQExpressionArray[1];
            }
        }
        return '';
    }
}
