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
		$fakerUs = \Faker\Factory::create();
		$tabEntreprise = array();
		//$stageRito1 = new Stage(
		
		for($i =0 ; $i < 14 ; $i = $i +1){
			$entreprise = new Entreprise();
			$nomEnt = $faker -> company;
			$entreprise->setNom($nomEnt);
			$entreprise->setAdresse($faker->address);
			$entreprise->setActivite($faker->realText($maxNbChars = 25, $indexSize = 2));
			$entreprise->setUrlSite("http://$nomEnt.fr");
			
			$manager->persist($entreprise);
			$tabEntreprise[$i] = $entreprise;
			
			
		}
		
		$tabNomFormation = array(
			"DUT INFO" => "DUT informatique",
			"DUT GEA" => "DUT gestion des entrprises et administration",
			"LP LA" => "licence professionnelle programation avancée"
		);
		
		$tabFormation = array();
		foreach($tabNomFormation as $nomCour => $nomLong){
			$formation = new Formation();
			$formation->setNom($nomCour);
			$formation->setNomComplet($nomLong);
			$tabFormation[] = $formation;
			$manager->persist($formation);
		}
		
		
		
		
		foreach	($tabEntreprise as $ent){
			$nbStage = $faker->numberBetween($min = 1, $max = 5);
			for($i = 0; $i < $nbStage ; $i++){

				$tabFormationMelange = $tabFormation;
				shuffle($tabFormationMelange);
				$nbFormation = $faker->numberBetween($min = 1, $max = sizeof($tabFormation));
				
				
				//création du stage
				$stage = new Stage();
				$stage->setTitre($faker->word);
				$stage->setMission($faker->realText($maxNbChars = 200, $indexSize = 2));
				$stage->setEmailContact($ent->getNom()."@".$faker->freeEmailDomain);
				
				// ajout liaison entre entrprise stage et formation
				for($j=0 ; $j<$nbFormation ; $j++){
					$stage->addFormation($tabFormationMelange[$j]);
					$tabFormationMelange[$j]->addStage($stage);
					$manager->persist($tabFormationMelange[$j] );
				}
				$stage->setEntreprise($ent);
				$ent -> addStage($stage);
				
				
				$manager->persist($ent );
				$manager->persist($stage);

			}
		
		}
		
		$manager-> flush();
    }
}
