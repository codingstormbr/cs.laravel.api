<?php

namespace App\Helpers;

class HttpResponse
{
    private $data = [];
    private $debug = [];
    private $paginate = [];
    private $message = [];
    private $status = null;

    const HTTP_STATUS = [
        ['code' => 100, 'name' => 'Continue'],
        ['code' => 101, 'name' => 'Switching Protocols'],
        ['code' => 102, 'name' => 'Processing'], // RFC2518
        ['code' => 200, 'name' => 'OK'],
        ['code' => 201, 'name' => 'Created'],
        ['code' => 202, 'name' => 'Accepted'],
        ['code' => 203, 'name' => 'Non-Authoritative Information'],
        ['code' => 204, 'name' => 'No Content'],
        ['code' => 205, 'name' => 'Reset Content'],
        ['code' => 206, 'name' => 'Partial Content'],
        ['code' => 207, 'name' => 'Multi-Status'], // RFC4918
        ['code' => 208, 'name' => 'Already Reported'], // RFC5842
        ['code' => 226, 'name' => 'IM Used'], // RFC3229
        ['code' => 300, 'name' => 'Multiple Choices'],
        ['code' => 301, 'name' => 'Moved Permanently'],
        ['code' => 302, 'name' => 'Found'],
        ['code' => 303, 'name' => 'See Other'],
        ['code' => 304, 'name' => 'Not Modified'],
        ['code' => 305, 'name' => 'Use Proxy'],
        ['code' => 306, 'name' => '(Unused)'],
        ['code' => 307, 'name' => 'Temporary Redirect'],
        ['code' => 308, 'name' => 'Permanent Redirect'], // RFC7538
        ['code' => 400, 'name' => 'Bad Request'],
        ['code' => 401, 'name' => 'Unauthorized'],
        ['code' => 402, 'name' => 'Payment Required'],
        ['code' => 403, 'name' => 'Forbidden'],
        ['code' => 404, 'name' => 'Not Found'],
        ['code' => 405, 'name' => 'Method Not Allowed'],
        ['code' => 406, 'name' => 'Not Acceptable'],
        ['code' => 407, 'name' => 'Proxy Authentication Required'],
        ['code' => 408, 'name' => 'Request Timeout'],
        ['code' => 409, 'name' => 'Conflict'],
        ['code' => 410, 'name' => 'Gone'],
        ['code' => 411, 'name' => 'Length Required'],
        ['code' => 412, 'name' => 'Precondition Failed'],
        ['code' => 413, 'name' => 'Payload Too Large'],
        ['code' => 414, 'name' => 'URI Too Long'],
        ['code' => 415, 'name' => 'Unsupported Media Type'],
        ['code' => 416, 'name' => 'Range Not Satisfiable'],
        ['code' => 417, 'name' => 'Expectation Failed'],
        ['code' => 421, 'name' => 'Misdirected Request'], // RFC7540
        ['code' => 422, 'name' => 'Unprocessable Entity'], // RFC4918
        ['code' => 423, 'name' => 'Locked'], // RFC4918
        ['code' => 424, 'name' => 'Failed Dependency'], // RFC4918
        ['code' => 425, 'name' => 'Too Early'], // RFC8470
        ['code' => 426, 'name' => 'Upgrade Required'], // RFC2817
        ['code' => 428, 'name' => 'Precondition Required'], // RFC6585
        ['code' => 429, 'name' => 'Too Many Requests'], // RFC6585
        ['code' => 431, 'name' => 'Request Header Fields Too Large'], // RFC6585
        ['code' => 451, 'name' => 'Unavailable For Legal Reasons'], // RFC7725
        ['code' => 500, 'name' => 'Internal Server Error'],
        ['code' => 501, 'name' => 'Not Implemented'],
        ['code' => 502, 'name' => 'Bad Gateway'],
        ['code' => 503, 'name' => 'Service Unavailable'],
        ['code' => 504, 'name' => 'Gateway Timeout'],
        ['code' => 505, 'name' => 'HTTP Version Not Supported'],
        ['code' => 506, 'name' => 'Variant Also Negotiates'], // RFC2295
        ['code' => 507, 'name' => 'Insufficient Storage'], // RFC4918
        ['code' => 508, 'name' => 'Loop Detected'], // RFC5842
        ['code' => 510, 'name' => 'Not Extended'], // RFC2774
        ['code' => 511, 'name' => 'Network Authentication Required'], // RFC6585
    ];

    public function data($data, $paginate = false)
    {
        if ($paginate) {
            $this->paginate = $this->paginate($data);
            $this->data =  ($data->items()) ? $data->items() : [];
        } else {
            $this->data = $data;
        }
        return $this;
    }

    public function parent($parent = '')
    {
        if (!empty(trim($parent))) {
            $parts = explode('.', $parent);
            $associativeArray = [];
            $current = &$associativeArray;

            foreach ($parts as $part) {
                $current[trim($part)] = [];
                $current = &$current[trim($part)];
            }

            $current = $this->data;
            $this->data = $associativeArray;
        }

        return $this;
    }

    public function paginate($data, $perRange = 5)
    {
        if ($data->items()) {
            $range = [];
            $lastPage = $data->lastPage();
            $currentPage = $data->currentPage();
            $leftRange = (($currentPage - $perRange) <= 1) ? 1 : ($currentPage - $perRange);
            $rigthRange = (($currentPage + $perRange) >= $lastPage) ? $lastPage : ($currentPage + $perRange);
            $previous = ($data->onFirstPage()) ? false : true;
            $next = ($data->hasMorePages()) ? true : false;

            for ($i = $leftRange; $i <= $rigthRange; $i++) {
                $range[] = [
                    'page' => $i,
                    'active' => ($currentPage === $i) ? true : false,
                ];
            }

            $paginate = [
                "currentPage" => $currentPage,
                "lastPage" => $lastPage,
                "previous" => $previous,
                "next" => $next,
                "range" => $range,

            ];
        } else {
            $paginate = [
                "previous" => false,
                "next" => false,
                "lastPage" => 0,
                "range" => [],
            ];
        }

        return $paginate;
    }

    public function message($message)
    {
        $this->message = is_array($message) ? $message : [$message];
        return $this;
    }

    public function debug($data = '')
    {
        if (!empty($data) && env('APP_ENV') == "local") {
            $this->debug = is_array($data) ? $data : [$data];
        }
        return $this;
    }

    private function prepareData($statusCode)
    {
        foreach (self::HTTP_STATUS as $http) {
            if ($http['code'] == $statusCode) {
                $this->status = $http['code'];
                $this->message = !empty($this->message) ? $this->message : $http['name'];
                break;
            }
        }
    }

    public function json($statusCode = 200)
    {
        $this->prepareData($statusCode);
        $_data = ['status' => $this->status, 'message' => $this->message, 'data' => $this->data];

        if (!empty($this->debug)) {
            $_data['debug'] = $this->debug;
        }

        if (!empty($this->paginate)) {
            $_data['paginate'] = $this->paginate;
        }

        return response()->json($_data, $this->status);
    }

    public function toArray($statusCode = 200)
    {
        $this->prepareData($statusCode);
        if (!empty($this->paginate)) {
            return [['status' => $this->status, 'message' => $this->message, 'paginate' => $this->paginate, 'data' => $this->data]];
        } else {
            return [['status' => $this->status, 'message' => $this->message, 'data' => $this->data]];
        }
    }

    public function toJson($data)
    {
        return response()->json($data);
    }
}
