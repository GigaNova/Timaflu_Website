<?php
/**
 * Created by PhpStorm.
 * User: GigaNova
 * Date: 11/8/2016
 * Time: 12:55
 */

namespace timaflu\core;

class Request
{
    private $baseurl;
    private $requesturl;

    private $requesttype;

    private $session;

    private $postdata;
    private $getdata;

    private $isAjax;

    public function __construct()
    {
        $this->requesturl = $_SERVER["REQUEST_URI"];
        $this->baseurl = $_SERVER["HTTP_HOST"];
        $this->requesttype = $_SERVER['REQUEST_METHOD'];

        if(!empty($_SESSION)){
            $this->session = $_SESSION;
        }else{
            $this->session = [];
        }

        self::handleRequests();
    }

    private function handleRequests(){
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->isAjax = true;
        }
        else {
            $this->isAjax = false;
        }

        $this->postdata = $_POST;
        $this->getdata = $_GET;
    }

    public function getRequestType(){
        return $this->requesttype;
    }

    public function getBaseUrl(){
        return $this->baseurl;
    }

    public function getRequestUrl(){
        return $this->requesturl;
    }

    public function post(){
        return $this->postdata;
    }

    public function get(){
        return $this->getdata;
    }
}