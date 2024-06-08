<?php

namespace App\Controller;

use App\Entity\Region;
use App\Service\PersonFactory;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends AbstractController
{

    private const PERSONS_CREATE_AMOUNT = 20;
    private const PERSONS_UPDATE_AMOUNT = 10;

    private const SEED_DEFAULT = 1234;

    private const ERRORS_AMOUNT_DEFAULT = 0;

    public function __construct(private PersonFactory $personFactory = new PersonFactory())
    {
    }

    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(PersonFactory $personFactory): Response
    {
        $persons = $this->personFactory->createMany(self::PERSONS_CREATE_AMOUNT);
        return $this->render('default/index.html.twig', [
            'regions' => Region::cases(),
            'persons' => $persons
        ]);
    }
    #[Route('/create', name: 'app_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer): Response
    {
        $postData = json_decode($request->getContent());
        $parameters = array();
        foreach ($postData as $data)
            $parameters[$data[0]] = $data[1];
        $persons = $this->personFactory->createMany(self::PERSONS_CREATE_AMOUNT, $parameters['seed'],  $parameters['error'],  $parameters['region']);
        $response = $this->renderView('default/persons.html.twig', [
            'persons' => $persons
        ]);

        return new Response($response);
    }

    #[Route('/update', name: 'app_update', methods: ['POST'])]
    public function update(Request $request): Response
    {
        $persons = $this->personFactory->updateMany(self::PERSONS_UPDATE_AMOUNT);

        $response = $this->renderView('default/persons.html.twig', [
            'persons' => $persons,
        ]);
        return new Response($response);
    }
}
