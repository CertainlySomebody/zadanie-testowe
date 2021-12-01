<?php

namespace App\Controller;

use App\Entity\Currency;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use App\Managers\ApiManager;

class CurrencyController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(ApiManager $apiManager, EntityManagerInterface $entityManager): Response
    {
        $data = $apiManager->handleCurrencies('https://api.nbp.pl/api/exchangerates/tables/A');

        $currencies = $entityManager->getRepository(Currency::class)->findAll();
        return $this->render('currency/index.html.twig', array(
            'data' => $currencies
        ));
    }

}
