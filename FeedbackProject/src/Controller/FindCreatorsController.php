<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FindCreatorsController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/find-creators-grid', name: 'app_find-creators-grid')]    
    public function findCreatorsGrid(): Response
    {
        $creators = $this->userRepository
        ->findBy(['isCreator' => true]);
        
        // dd($creators);

        return $this->render('find_creators_grid.html.twig', [
            'creators' => $creators,
        ]);
    }

    #[Route('/find-creators-list', name: 'app_find-creators-list')]    
    public function findCreatorsList(): Response
    {
        $creators = $this->userRepository
        ->findBy(['isCreator' => true]);
        
        return $this->render('find_creators_list.html.twig', [
            'creators' => $creators,
        ]);
    }

    #[Route('/find-creators-accordion', name: 'app_find-creators-accordion')]    
    public function findCreatorsAccordion(): Response
    {
        $creators = $this->userRepository
        ->findBy(['isCreator' => true]);
        
        return $this->render('find_creators_accordion.html.twig', [
            'creators' => $creators,
        ]);
    }

    #[Route('/find-creators-table', name: 'app_find-creators-table')]    
    public function findCreatorsTable(): Response
    {
        $creators = $this->userRepository
        ->findBy(['isCreator' => true]);
        
        return $this->render('find_creators/find_creators_table.html.twig', [
            'creators' => $creators,
        ]);
    }
}
