<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

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
    public function AfficherFormulaireAjoutEntreprise(Request $request,EntityManagerInterface $manager): Response
    {
       
		//recuperer le repository de l'entitée Stage
        
       $ent = new Entreprise();
 
        // renvoie tous les stage qui ont pour codeEntreprise l'id donner
		
		$formEnt = $this->createFormBuilder($ent)
			->add('nom',TextType::class,['attr' =>['placeholder' =>"nom de l'entreprise...."]])
			->add('adresse', TextareaType::class,['attr' =>['placeholder' =>"30 rue des piaf"]])
			->add('activite',TextType::class,['attr' =>['placeholder' =>"Informatique emnbarquée .."]])
			->add('urlsite',UrlType::class,['attr' =>['placeholder' =>"http://symfony.com"]])
			
			->getForm();
			
		$formEnt->handleRequest($request);
			
		if($formEnt->isSubmitted()){
			$manager->persist($ent);
			$manager->flush();
			
			return $this->redirectToRoute('accueil');
		}
		
	
		$vueFormualaire = $formEnt -> createView();
        return $this->render('pro_stage/pageAjoutModifEntreprise.html.twig', ['vueFormualaire'=>$vueFormualaire
		, 'action'=>'ajouter'

           
        ]);
	
	}
	
	/**
     * @Route("/modifierUneEntreprise/{id}", name="proStage_modifierEntreprises")
     */
    public function AfficherFormulaireModificationEntreprise(Request $request,EntityManagerInterface $manager, Entreprise $entreprise): Response
    {
       

		
		$formEnt = $this->createFormBuilder($entreprise)
			->add('nom',TextType::class)
			->add('adresse', TextareaType::class)
			->add('activite',TextType::class)
			->add('urlsite',UrlType::class)
			
			->getForm();
			
		$formEnt->handleRequest($request);
			
		if($formEnt->isSubmitted()){
			$manager->persist($entreprise);
			$manager->flush();
			
			return $this->redirectToRoute('accueil');
		}
		
	
		$vueFormualaire = $formEnt -> createView();
        return $this->render('pro_stage/pageAjoutModifEntreprise.html.twig', ['vueFormualaire'=>$vueFormualaire ,
			'action'=>'modifier'

           
        ]);
	
	}

}
