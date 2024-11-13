<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use App\Form\PostCreateForm;
use App\Entity\User;
use App\Entity\Project;

class PostController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    // Ruta publica POST VIEW BRANCH INDEX placeholder
    #[Route('/posts', name: 'app_posts')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }


    #[Route('/posts_create/{projectId}',
     name: 'app_posts_create')]
    public function createPost(int $projectId,
    Request $request,
    EntityManagerInterface $entityManager
    ): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $id = $user->getId();

        /** @var Project $project */
        $project = $entityManager
        ->getRepository(Project::class)
        ->find($projectId);

        if (!$project) 
        {
            throw $this->createNotFoundException('EL PROYECTO NO EXISTE');
        }

        $post = new Post();
        $form = $this->createForm(PostCreateForm::class, 
        $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager;

            $post->setProject($project);
            $post->setAuthor($user);

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_posts_sucess');

        }
        return $this->render('post/postCreate.html.twig', 
        parameters:[
            'postCreateForm'=> $form->createView()]);

    }
    
    #[Route('/postSucess', name: 'app_posts_sucess')]
    public function postSucessShow(): Response
    {
        return $this->render('post/PostCreateSucess.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }
    
}