<?php

namespace App\Controller;

use App\Service\PersonFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{

    private const PERSONS_CREATE_AMOUNT = 20;
    private const PERSONS_UPDATE_AMOUNT = 10;
    #[Route('/', name: 'app_index')]
    public function index(PersonFactory $personFactory): Response
    {
        $persons = $personFactory->createMany(self::PERSONS_CREATE_AMOUNT);
        return $this->render('default/index.html.twig', [
            'persons' => $persons,
        ]);
    }

    #[Route('/update', name: 'app_update')]
    public function update(PersonFactory $personFactory): Response
    {
        $persons = $personFactory->updateMany(self::PERSONS_UPDATE_AMOUNT);

        return $this->render('default/index.html.twig', [
            'persons' => $persons,
        ]);
    }
}
