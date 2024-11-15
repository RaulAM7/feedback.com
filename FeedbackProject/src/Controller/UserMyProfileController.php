<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\Post;


class UserMyProfileController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/user/my-profile', name: 'app_user_my_profile')]
    public function index(): Response
    {
        return $this->render('user_my_profile/index.html.twig', [
            'controller_name' => 'UserMyProfileController',
        ]);
    }

    #[Route('/user/my-profile-test', name: 'app_user_my_profile-test')]
    public function showTest1(): Response
    {
        return $this->render('user_my_profile/MyProjects-test1.html.twig', [
            'controller_name' => 'UserMyProfileController',
        ]);
    }

    #[Route('/user/my-projects-test-card', name: 'app_user_my_projects-test-card')]
    public function showCard(EntityManagerInterface $entityManager): Response
    {
        
        /** @var User $user */
        $user = $this->getUser();
        $id = $user->getId();

        $posts = $user->getPosts();

        return $this->render('user_my_profile/MyProjects-Posts-Dashboard-Card.html.twig',
         [
            'posts'=> $posts,
            'controller_name' => 'UserMyProfileController',
        ]);
    }

    #[Route('/user/my-projects-test-hybrid', name: 'app_user_my_projects-test-hybrid')]
    public function showHybrid(EntityManagerInterface $entityManager): Response
    {

        /** @var User $user */
        $user = $this->getUser();
        $id = $user->getId();

        $posts = $user->getPosts();

        $projects = $user->getProjectsOwned();


        return $this->render(
            'user_my_profile/MyProjects-Posts-Dashboard-Hybrid.html.twig',
            [
                'posts' => $posts,
                'projects' => $projects,
                'controller_name' => 'UserMyProfileController',
            ]
        );
    }


    #[Route('/user/my-projects-test-list', name: 'app_user_my_projects-test-list')]
    public function showList(EntityManagerInterface $entityManager): Response
    {

        /** @var User $user */
        $user = $this->getUser();
        $id = $user->getId();

        $posts = $user->getPosts();

        $projects = $user->getProjectsOwned();

        return $this->render(
            'user_my_profile/MyProjects-Posts-Dashboard-List.html.twig',
            [
                'posts' => $posts,
                'projects' => $projects,
                'controller_name' => 'UserMyProfileController',
            ]
        );
    }

}
