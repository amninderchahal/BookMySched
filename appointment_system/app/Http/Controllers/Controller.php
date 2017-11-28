<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use GuzzleHttp\Client;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static $baseUri = ['base_uri' => 'http://localhost:9000'];
    public static $api_token = 'hdMTf1TAAPyzrIlZb2JJrjBBTnkCBvZOsIHIpQ2O3IIiA9r53RU1tQ1FCQKj';

    //Get organization id
    protected function getOrgId($org_id){

        if (session('role_id')==1)
            return $org_id;

        else
            return session('organization_id');
    }

    //Get employee id
    protected function getEmpId($emp_id){

        if (session('role_id')==1||session('role_id')==2)
            return $emp_id;

        else
            return session('id');
    }

    //Get all organizations
    public function getOrgData(){

        $res = $this->getRequest('/api/organization/getAll');
        return $res->getBody();
    }

    // API methods
    public function postRequest($uri){

        $client = new Client(Self::$baseUri);

        $data = array(
           'api_token' => Self::$api_token
        );

        $res = $client->post($uri, array(
            'headers'=>['Accept'     => 'application/json'],
            'query' => $data
        ));

        return $res;
    }

    public function getRequest($uri){

        $client = new Client(Self::$baseUri);

        $data = array(
           'api_token' => Self::$api_token
        );

        $res = $client->get($uri, array(
            'headers'=>['Accept'     => 'application/json'],
            'query' => $data
        ));

        return $res;
    }

    public function postData($uri, $formData){

        $client = new Client(Self::$baseUri);

        $requestData = array(
           'api_token' => Self::$api_token
        );

        $data = array_merge($requestData, $formData);

        $res = $client->post($uri, array(
            'headers'=>['Accept'     => 'application/json'],
            'query' => $data
        ));

        return $res;
    }
    public function getData($uri, $formData){

        $client = new Client(Self::$baseUri);

        $requestData = array(
           'api_token' => Self::$api_token
        );

        $data = array_merge($requestData, $formData);

        $res = $client->get($uri, array(
            'headers'=>['Accept' => 'application/json'],
            'query' => $data
        ));

        return $res;
    }
}
