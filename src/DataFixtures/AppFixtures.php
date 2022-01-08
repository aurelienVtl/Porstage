<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       
		$faker = \Faker\Factory::create('fr_FR');
		$tabEntreprise[];
		//$stageRito1 = new Stage(
		
		for($i =0 ; $i < 5 ; $i = $i +1){
			$entreprise = new Entreprise();
			$nomEnt = $faker -> company;
			$entreprise->setNom($nomEnt);
			$entreprise->setAdresse($faker->address);
			$entreprise->setActivite($faker->realText($maxNbChars = 25, $indexSize = 2));
			$entreprise->setUrlSite("http://$nomEnt.fr");
			
			$manager->persist($entreprise);
			$tabEntreprise[$i] = $entreprise;
			
			
		}
		
		$tabFormation = array(
			"DUT INFO" => "diplome universitaire et technologique informatique",
			"DUT GEA" => "diplome universitaire et technologique gestion des entrprises et administration"
			"LP LA" => "licence professionnelle programation avancée"
		);
		
		
		foreach($tabFormation as $nomCour => $nomLong){
			$formation = new Formation();
			$formation->setNom($nomCour);
			$formation->setNomComplet($nomLong);
			$tabFormation[] = $entreprise;
			$manager->persist($formation);
		}
		
		
		$manager->flush();
		
		foreach	($tabEntreprise as $ent){
			$nbStage = $faker->numberBetween($min = 1, $max =5);
			for($i = 0; $i < $nbStage ; $i++){
				$stage = new Stage();
				$stage->setTitre($faker->jobTitle);
				$stage->setMission($faker->sentence($nbWords = 30 , $variableNbWords = true));
				$stage->setEmailContact("$ent->getNom()@gmail.com");
				
			}
			
    }
}
