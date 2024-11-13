<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Form\ProjectCreateForm;
use App\Entity\User;
class ProjectController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Ruta publica PROJECT VIEW BRANCH INDEX placeholder
    #[Route('/project', name: 'app_project')]
    public function index(): Response
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }

    #[Route('/project/create', name: 'app_project_create')]

    public function createProject(Request $request,
    EntityManagerInterface $entityManagerInterface): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $id = $user->getId();

        $project = new Project();
        $form = $this->createForm(ProjectCreateForm::class,
         $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager;

            $project->setOwner($this->getUser());   
            
            $entityManager->persist($project);
            $entityManager->flush();


            return $this->redirectToRoute(
                'app_project_sucess'
            );
        }
        return $this->render('project/projectCreate.html.twig',
         parameters: [
            'projectCreateForm' => $form->createView(),
            'id' => $id
        ]);
    }

    #[Route('/projectSucess', name: 'app_project_sucess')]
    public function projectSucessShow(): Response
    {
        return $this->render('project/ProjectCreateSucess.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }
}