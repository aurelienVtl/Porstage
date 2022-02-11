<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;

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
     * @Route("/stages/{id}", name="proStage_detailStage")
     */
	public function afficherStages(Stage $stage): Response
    {	
		/* 		Sans les dépendances 
		//récupérer le repository
		$repositoryStage = $this->getDoctrine()->getRepository(stage::class);
		
		//récuperer les donneés de la BD
		$stage = $repositoryStage -> find($id);
		
		//envoi des données à la vue
		*/
        return $this->render('pro_stage/pageDetailsStage.html.twig', [
            'stage' => $stage
        ]);
    }
	

	/**
     * @Route("/formations", name="proStage_formations")
     */
	public function afficherFormations(): Response
    {
         //récupérer le repository
		$repositoryFormations = $this->getDoctrine()->getRepository(Formation::class);
			
		//récuperer les donneés de la BD
		$formations = $repositoryFormations -> findAll();
		 return $this->render('pro_stage/pageFormations.html.twig', [
			"listeFormations" => $formations
        ]);
    }
	
	/**
     * @Route("/entreprises", name="proStage_entreprises")
     */
	public function afficherEntreprises(): Response
    {
         //récupérer le repository
		$repositoryEntreprise = $this->getDoctrine()->getRepository(entreprise::class);
			
		//récuperer les donneés de la BD
		$entreprises = $repositoryEntreprise -> findAll();
		 return $this->render('pro_stage/pageEntreprises.html.twig', [
			"listeEntreprises" => $entreprises
        ]);
    }
	
	
	/**
     * @Route("/entrepriseStages/{nom}", name="proStage_entrepriseStages")
     */
    public function AfficherEntrepriseStages(StageRepository $repositoryStage, $nom): Response
    {
		
		/* 		Sans les dépendances 
			//recuperer le repository de l'entitée Stage
			$repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
			//recuperer les ressources de l'entité Ressource

			$stagesDeEnt = $repositoryStage->findBy(['entreprise'=>$id]); 
			// renvoie tous les stage qui ont pour codeEntreprise l'id donner
		*/
		$stagesDeEnt = $repositoryStage->findStagesDeLEntreprise($nom); 
		
        return $this->render('pro_stage/pageEntrepriseStages.html.twig', [

           'listeStages'=>$stagesDeEnt, 'nomEnt'=>$nom,
        ]);
	
	}
	
	/**
     * @Route("/formationStages/{nom}", name="proStage_formationStages")
     */
    public function AfficherFormationStages($nom): Response
    {
       
		//recuperer le repository de l'entitée Stage
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        //recuperer les ressources de l'entité Ressource
 
        // renvoie tous les stage qui ont pour codeEntreprise l'id donner
		
		
		$stagesDeForm = $repositoryStage->findStagesDeLaFormation($nom);
        return $this->render('pro_stage/pageFormationStages.html.twig', [

           'stages'=>$stagesDeForm,
        ]);
	
	}
	
	
	/**
     * @Route("/ajouterUneEntreprise", name="proStage_ajoutEntreprises")
     */
    public function AfficherFormulaireAjoutEntreprise(): Response
    {
       
		//recuperer le repository de l'entitée Stage
        
       $ent = new Entreprise();
 
        // renvoie tous les stage qui ont pour codeEntreprise l'id donner
		
		$formEnt = $this->createFormBuilder($ent)
			->add('nom')
			->add('adresse')
			->add('activite')
			->add('urlsite')
			->getForm();
		
	
		$vueFormualaire = $formEnt -> createView();
        return $this->render('pro_stage/pageAjoutEntreprises.html.twig', ['vueFormualaire'=>$vueFormualaire

           
        ]);
	
	}

}
