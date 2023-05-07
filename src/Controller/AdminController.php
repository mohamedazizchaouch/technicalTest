<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Manager\ProjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Enum\StatusType;

class AdminController extends AbstractController
{

    private $projectManager ;

    public function __construct(ProjectManager $projectManager)
    {
        $this->projectManager = $projectManager;
    }
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request): Response
    {   
        $params = $request->query->all();
        $choices = StatusType::getAsArray(); 
         if(true === isset( $params['search_by_name']) &&
            true === isset( $params['search_by_status']) &&
            true === isset( $params['search_by_url']) )
            {
                $projects = $this->projectManager->getProjectsByFilter($params);
                if (count($projects) === 0){
                    $this->addFlash('notice', 'selon vos critere de recherche aucun project a affiché  ');
                }
            }else{
                $projects = $this->projectManager->getAllProjects();
                
            }
       
        
        return $this->render('admin/index.html.twig', [
            'projects' => $projects,
            'choices' =>$choices
        ]);
    }
    #[Route('/admin/create', name: 'app_admin_create')]
    public function addProduct(Request $request)
    {   
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $image =  $form->get('image')->getData();
            $result= $this->projectManager->createProject($project,$image);

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('project/createProject.html.twig', [
            'projectForm' => $form->createView(),
        ]);
    }
    #[Route('/admin/edit-project/{id}', name: 'app_admin_editProject')]
    public function updateProject(Request $request, Project $project)
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $image =  $form->get('image')->getData();
            
             $this->projectManager->updateProject($project,$image);
 
             return $this->redirectToRoute('app_admin');
         }

         return $this->render('project/updateProject.html.twig', [
            'projectForm' => $form->createView(),
            'project' => $project
        ]);
    }

    #[Route('/admin/delete-project/{id}', name: 'app_admin_deleteProject')]
    public function deleteProject(Request $request, Project $project)
    {   
        $this->projectManager->deleteProject($project);
         return $this->redirectToRoute('app_admin');
    }

   



}
