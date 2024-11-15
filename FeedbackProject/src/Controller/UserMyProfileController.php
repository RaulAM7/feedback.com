<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserMyProfileController extends AbstractController
{
    #[Route('/user/my-profile', name: 'app_user_my_profile')]
    public function index(): Response
    {
        return $this->render('user_my_profile/index.html.twig', [
            'controller_name' => 'UserMyProfileController',
        ]);
    }
}
