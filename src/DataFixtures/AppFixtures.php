<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       
        // $manager->persist($product);
		$entrepriseDevWeb = new Entreprise();
		$entrepriseDevWeb->setNom("ritoGamez");
		$entrepriseDevWeb->setAdresse("30 rue des pigeon");
		$entrepriseDevWeb->setActivite("jeux vidéo");
		$entrepriseDevWeb->setUrlSite("http://tito");
		
		$manager->persist($entrepriseDevWeb);
        $manager->flush();
    }
}
