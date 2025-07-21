<?php

namespace App\Form;

use App\Entity\Bouteilles;
use App\Entity\Regions;
use App\Entity\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;

class WineFilterType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'Nom du vin',
                'attr' => ['placeholder' => 'Entrez un nom de vin']
            ])
            ->add('year', IntegerType::class, [
                'required' => false,
                'label' => 'Année du vin',
                'attr' => ['placeholder' => 'Entrez une année']
            ])
            ->add('regions', EntityType::class, [
                'class' => Regions::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Sélectionnez une région',
                'label' => 'Regions'
            ])
            // ->add('cepage', EntityType::class, [
            //     'class' => Cepage::class,
            //     'choice_label' => 'name',
            //     'multiple' => true,
            //     'expanded' => true,
            //     'required' => false,
            //     'label' => 'Cépage'
            // ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
