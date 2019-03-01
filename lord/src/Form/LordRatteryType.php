<?php

namespace App\Form;

use App\Entity\LordRattery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\LordUserRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LordRatteryType extends AbstractType
{
    public function __construct(LordUserRepository $lordUserRepository)
    {
        $this->lordUserRepository = $lordUserRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addUserOwner($builder);

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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LordRattery::class,
        ]);
    }

    private function addUserOwner(FormBuilderInterface $builder)
    {
        $builder->add('userOwner', ChoiceType::class, [
            'required' => true,
            'choices' => $this->lordUserRepository->findAll(),
            'choice_label' => 'getUsername',
            'choice_value' => 'getId'
        ]);
    }
}
