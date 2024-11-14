<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DesignTestingController extends AbstractController
{
    #[Route('/design_testing', name: 'app_design_testing')]
    public function index(): Response
    {
        return $this->render('design_testing/testing3.html.twig', [
            'controller_name' => 'DesignTestingController',
        ]);
    }
}
