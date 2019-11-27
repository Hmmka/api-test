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
            $this->id = intval($this->uri[2]);
        }
    }

    protected function sendData($json)
    {
        echo json_encode(array($this->service::$serviceName => $json));
    }

    public function run()
    {
        if (($this->method == 'PUT' || $this->method == 'DELETE') && !$this->id) {
            throw new \Exception("Missing " . $this->service::$serviceName . " id");
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
            default:
                throw new \Exception("Missing method in the '" . $this->service::$serviceName . "' service. (magic)");
        }

        header($this->responseStatus);
        if ($this->responseBody) {
            $this->sendData($this->responseBody);
        }
    }
}
