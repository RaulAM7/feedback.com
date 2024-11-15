<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'title' => 'HOME'
        ]);
    }
    
    #[Route('/home-test', name: 'app_home-test')]
    public function showTest(): Response
    {
        return $this->render('home/home-Landing.html.twig', [
            'controller_name' => 'HomeController',
            'title' => 'HOME'
        ]);
    }
}