<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
		
		//récupérer le repository
		$repositoryStage = $this->getDoctrine()->getRepository(stage::class);
		
		//récuperer les donneés de la BD
		$stages = $repositoryStage -> findAll();
		
		//envoi des données à la vue
        return $this->render('pro_stage/index.html.twig', [
            'listeStages' => $stages]
		);
    }
	
	/**
     * @Route("/stages/{id}", name="pro_stage_stages")
     */
	public function afficherStages($id): Response
    {
        return $this->render('pro_stage/pageStages.html.twig', [
            'controller_name' => 'ProStageController', 'id' => $id
        ]);
    }
	

	/**
     * @Route("/formations", name="pro_stage_formations")
     */
	public function afficherFormations(): Response
    {
        return $this->render('pro_stage/pageFormations.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }
	
	/**
     * @Route("/entreprises", name="pro_stage_entreprise")
     */
	public function afficherEntreprises(): Response
    {
        return $this->render('pro_stage/pageEntreprises.html.twig', [
            'controller_name' => 'ProStageController', 
        ]);
    }
}
