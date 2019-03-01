<?php

namespace App\Form;

use App\Entity\LordRattery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LordRatteryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ratteryName')
            ->add('rateriePrefix')
            ->add('ratteryComments')
            ->add('ratteryPicture')
            ->add('ratteryStatus')
            ->add('ratteryValidated')
            ->add('ratteryDateBirth')
            ->add('ratteryDateCreation')
            ->add('ratteryDateLastUpdate')
            // @TODO: trouver comment mapper un champs du formulaire à une autre entité
            // ->add('userOwner')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LordRattery::class,
        ]);
    }
}
