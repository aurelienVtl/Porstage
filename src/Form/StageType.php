<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\EntrepriseType;
use App\Form\StageType;
use App\Entity\Entreprise;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('mission')
            ->add('emailContact')
			->add('entreprise',  EntrepriseType::class)
			->add('formations',  EntityType::class,[
				'class'=>Formation::class,
				'choice_label'=> 'nomComplet',
				'multiple'=>true,
				'expanded'=>true,
			])
				;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
