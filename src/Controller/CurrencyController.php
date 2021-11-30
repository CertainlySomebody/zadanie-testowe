<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Managers\ApiManager;

class CurrencyController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(ApiManager $apiManager): Response
    {
        $data = $apiManager->GetCurrencies('https://api.nbp.pl/api/exchangerates/tables/A');
//        dd($data[0]->rates);
        return $this->render('currency/index.html.twig', array(
            'data' => $data[0]->rates
        ));
    }

}
