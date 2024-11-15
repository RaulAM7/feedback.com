<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FindCreatorsController extends AbstractController
{
    #[Route('/find-creators', name: 'app_find_creators')]
    public function index(): Response
    {
        return $this->render('find_creators/findCreators-test1.html.twig', [
            'controller_name' => 'FindCreatorsController',
        ]);
    }
}
