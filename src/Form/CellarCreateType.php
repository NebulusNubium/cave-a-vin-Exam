<?php

namespace App\Form;

use App\Entity\Bouteilles;
use App\Entity\Cave;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CellarCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('bouteilles', EntityType::class, [
            //     'class' => Bouteilles::class,
            //     'choice_label' => 'name',
            //     'multiple' => true,
            // ])
            ->add('name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cave::class,
        ]);
    }
}
