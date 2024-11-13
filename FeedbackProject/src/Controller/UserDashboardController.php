<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserDashboardController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createNotFoundException('User not found');
        }
        $id = $user->getId();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserDashboardController',
            'id' => $id,
        ]);
    }

    #[Route('/user/updateToData', name: 'app_user_update', methods: ['POST'])]
    public function updateData(Request $request): Response
    {
        $user = $this->getUser();
        $user->getRoles();
        if (!$user instanceof User) {
            throw $this->createNotFoundException('User not found');
        }
        // if ($request->get('_method') === 'POST')
        // {
            $user->setName($request->request->get('name'));
            $user->setEmail($request->request->get('email'));
            $user->setUsername($request->request->get('username'));
            $user->setPhoneNumber($request->request->get('phoneNumber'));
            
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            
        return $this->redirectToRoute('app_user_dashboard');
        // } 
        // else
        // {
        //     return $this->render('user/updateDataFailure.html.twig', [
        //         'controller_name' => 'UserupdateDataController',
        //     ]);            
        // }
    }

    #[Route('/user/updateData', name: 'app_user_get_form')]
    public function updateDataShow(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createNotFoundException('User not found');
        }
        $id = $user->getId();
        
        return $this->render('user/updateData.html.twig', [
            'controller_name' => 'UserupdateDataController',
            'id' => $id,
        ]);
    }


    #[Route('/user/dashboard', name: 'app_user_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('user/dashboard.html.twig', [
            'controller_name' => 'UserDashboardController',
        ]);
    }
}
