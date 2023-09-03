<?php

namespace App\Form;

use App\Entity\Vehicles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VehicleFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vehicleName', null, ['required' => false])
            ->add('plateNumber', null, ['required' => false])
            ->add('category', null, ['required' => false])
            ->add('acquiringDate', null, ['required' => false])
            ->add('fuelType', null, ['required' => false])
            ->add('filter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicles::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
