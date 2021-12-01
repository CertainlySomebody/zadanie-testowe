<?php

namespace App\Managers;

use App\Entity\Currency;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class ApiManager
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function handleCurrencies(string $json) {

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $api = file_get_contents($json);

        $data = json_decode($api);

        $this->putCurrencies($data);


    }

    public function putCurrencies($data) {
        $em = $this->entityManager;
        $count = count($data[0]->rates);
        //dd($data[0]->rates);

        for($i = 0; $i<$count; $i++) {
            $check = $em->getRepository(Currency::class)->findBy(['currency_code' => $data[0]->rates[$i]->code]);
            if($check) {

                $qb = $em->createQueryBuilder();
                $qb->update('App\Entity\Currency', 'Currency');
                $qb->set('Currency.exchange_rate', ':exchange');
                $qb->setParameter('exchange', $data[0]->rates[$i]->mid);
                $qb->getQuery()->execute();

            }else{

                $create = new Currency();
                $create->setName($data[0]->rates[$i]->currency);
                $create->setCurrencyCode($data[0]->rates[$i]->code);
                $create->setExchangeRate($data[0]->rates[$i]->mid);
                $em->persist($create);

            }

            $em->flush();
        }

        return new Response('Updating Currency');
    }



}
