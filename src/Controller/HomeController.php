<?php

namespace App\Controller;

use App\Enum\StatusType;
use App\Manager\ProjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $projectManager ;

    public function __construct(ProjectManager $projectManager)
    {
        $this->projectManager = $projectManager;
    }

    #[Route('/home', name: 'app_home')]
    public function home(Request $request): Response
    {
        $params = $request->query->all();
        $choices = StatusType::getAsArray(); 
         if(true === isset( $params['search_by_name']) &&
            true === isset( $params['search_by_status']) &&
            true === isset( $params['search_by_url']) )
            {
                $projects = $this->projectManager->getProjectsByFilter($params);
                if (count($projects) === 0){
                    $projects = $this->projectManager->getAllProjects();
                    $this->addFlash('notice', 'selon vos critere de recherche aucun project a affiché  ');
                }
            }else{
                $projects = $this->projectManager->getAllProjects();
                
            }
       
        
        return $this->render('home/index.html.twig', [
            'projects' => $projects,
            'choices' =>$choices
        ]);
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_home');
    }
}
