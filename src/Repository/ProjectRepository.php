<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry,Project::class);
    }
    /**
     * Undocumented function
     *
     * @param Project $project
     * @return void
     */
    public function createProject(Project $project)
    {
        $this->getEntityManager()->persist($project);
        $this->getEntityManager()->flush();
        
    }
    /**
     * Undocumented function
     *
     * @return array()
     */
    public function getAllProjects()
    {
        return $this->findAll();
    }

    public function updateProject (Project $project)
    {    
        $this->getEntityManager()->flush();
    }

    public function deleteProject(Project $project)
    {
        $this->getEntityManager()->remove($project);
        $this->getEntityManager()->flush();
    }

    public function getProjectsByFilter( array $params)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->where('1 = 1');
        if ($params['search_by_name'] !== ''){
            $queryBuilder->andWhere('p.title LIKE :title');
            $queryParms['title'] = $params['search_by_name'];
        }
        if ($params['search_by_status'] !== ''){
            $queryBuilder->andWhere('p.status LIKE :status');
            $queryParms['status'] = $params['search_by_status'];
        }
        if ($params['search_by_filename'] !== ''){
            $queryBuilder->andWhere('p.url LIKE :url');
            $queryParms['url'] = $params['search_by_url'];
        }
        $queryBuilder->setParameters($queryParms);
        return  $queryBuilder->getQuery()->getResult();

    }
  
}