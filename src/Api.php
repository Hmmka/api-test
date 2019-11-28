<?php

namespace Src;

class Api
{
    public    $uri = null;
    public    $method = null;
    protected $id = null;
    protected $service = null;
    protected $body = null;

    protected $responseBody = null;
    protected $responseStatus = 'HTTP/1.1 200 OK';

    /**
     * @param Service $product
     */
    public function __construct(Service $product)
    {
        $this->service = $product;
        $this->uri = explode("/", $_SERVER['REQUEST_URI']);
        $this->method = $_SERVER['REQUEST_METHOD'];

        if ($this->method == 'PUT' || $this->method == 'POST') {
            $this->body = json_decode(file_get_contents('php://input'), true);
        }

        if ($this->uri[1] != $this->service::$serviceName) {
            throw new \Exception("The wrong name of the service.");
        }

        if (isset($this->uri[2])) {
            $this->checkId($this->uri[2]);
            $this->id = intval($this->uri[2]);
        }
    }

    /**
     * @param array $json
     * @return void
     */
    protected function sendData($json)
    {
        echo json_encode(array($this->service::$serviceName => $json));
    }

    /**
     * @return void
     */
    public function run()
    {
        if (($this->method == 'PUT' || $this->method == 'DELETE') && !$this->id) {
            throw new \Exception("Missing " . $this->service::$serviceName . " id.");
        }
        switch ($this->method) {
            case 'GET':
                if ($this->id) {
                    $this->responseBody = $this->service->find($this->id);
                } else {
                    $this->responseBody = $this->service->findAll();
                }
                break;
            case 'POST':
                $this->responseBody = $this->service->create($this->body);
                $this->responseStatus = 'HTTP/1.1 201 Created';
                break;
            case 'PUT':
                $this->responseBody = $this->service->update($this->id, $this->body);
                break;
            case 'DELETE':
                $this->responseBody = $this->service->delete($this->id);
                break;
            case 'OPTIONS':
                echo json_encode("{mes: 'This is working just fine'}");
            default:
                throw new \Exception("Allowed methods: GET, PUT, POST, DELETE");
                break;
        }

        header($this->responseStatus);
        if ($this->responseBody) {
            $this->sendData($this->responseBody);
        }
    }

    /**
     * @param [type] $value
     * @return void
     */
    protected function checkId($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            throw new \Exception($this->service::$serviceName . " id should be an integer.");
        }
    }
}
