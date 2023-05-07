<?php

namespace App\Manager;

use App\Entity\Project;
use App\Repository\ProjectRepository;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProjectManager
{
    private $projectRepository;
    private  $slugger;
    private $mailer;
    private $security;

    public function __construct(ProjectRepository $projectRepository ,
    SluggerInterface $slugger,MailerInterface $mailer ,AuthenticationUtils $security)
    {
        $this->projectRepository = $projectRepository;
        $this->slugger= $slugger;
        $this->mailer = $mailer;
        $this->security = $security;
    }

    /**
     * Undocumented function
     *
     * @param Project $project
     * @return void
     */
   public function createProject(Project $project,File $image)
   {
   
        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
        // Move the file to the directory where images are stored
        try {
            $project->setFilname($newFilename);
            $project->setImage(file_get_contents($image->getPathname()));
            $image->move(
            '../public/images',
            $newFilename
        );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }
    
        return $this->projectRepository->createProject($project);
   }

   /**
     * Undocumented function
     *
     * @return array()
     */
    public function getAllProjects()
    {
        return $this->projectRepository->getAllProjects();
    }
    /**
     * Undocumented function
     *
     * @param Project $project
     * @param File $image
     * @return void
     */
    public function updateProject(Project $project,File $image)
    {   
        if(true === isset($image)){
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
            // Move the file to the directory where images are stored
            try {
                $project->setFilname($newFilename);
                $project->setImage(file_get_contents($image->getPathname()));
                $image->move(
                '../public/images',
                $newFilename
            );
            $emailAdmin = $this->security->getLastUsername();
            $email = (new Email())
           // ->from('') ajouter une addresse mail
            ->to($emailAdmin)
            ->subject('image modifier ')
            ->text("l'image du project num".$project->getId()."a été modifier avec succes");

            $this->mailer->send($email);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
        }
        return $this->projectRepository->updateProject($project);
    }

    public function deleteProject(Project $project)
    {
        return $this->projectRepository->deleteProject($project);
    }


    public function getProjectsByFilter (array $parms)
    {
        return $this->projectRepository->getProjectsByFilter($parms);
    }

    // Other methods for updating and deleting entities...
}
