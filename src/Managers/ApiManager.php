<?php

namespace App\Managers;

use App\Entity\Currency;
use Symfony\Component\HttpFoundation\Response;

class ApiManager
{

    public function GetCurrencies(string $json) {

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $api = file_get_contents($json);

        return json_decode($api);
    }

}
