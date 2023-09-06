<?php

namespace App\Form;

use App\Entity\Vehicles;
use App\Constants\CarTypes;
use App\Constants\FuelTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VehicleFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vehicleName', null, ['required' => false])
            ->add('plateNumber', null, ['required' => false])
            ->add('category', ChoiceType::class, [
                'required' => false,
                'choices' => CarTypes::CARTYPES
            ])
            ->add('acquiringDate', null, ['required' => false])
            ->add('fuelType', ChoiceType::class, [
                'required' => false,
                'choices' => FuelTypes::FUEL_TYPES,
            ])
            ->add('filter', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
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
