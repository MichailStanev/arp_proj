<?php

namespace App\Form;

use App\Entity\Vehicles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class VehiclesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vehicleName', null, [
                'required' => true,
                'label' => 'Vehicle Name',
                'attr' => [
                    'placeholder' => 'Vehicle Name',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a vehicle name',
                    ])
                ],
                'label_attr' => [
                    'class' => 'form-label',
                ]
            ])
            ->add('plateNumber', null, [
                'required' => true,
                'label' => 'Plate Number',
                'attr' => [
                    'placeholder' => 'Plate Number',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a plate number',
                    ])
                ],
                'label_attr' => [
                    'class' => 'form-label',
                ]
            ])
            ->add('category', null, [
                'required' => true,
                'label' => 'Category',
                'attr' => [
                    'placeholder' => 'Category',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a category',
                    ])
                ],
                'label_attr' => [
                    'class' => 'form-label',
                ]
            ])
            ->add('acquiringDate', null, [
                'required' => true,
                'label' => 'Acquiring Date',
                'attr' => [
                    'placeholder' => 'Acquiring Date',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a acquiring date',
                    ])
                ],
                'label_attr' => [
                    'class' => 'form-label',
                ]
            ])
            ->add('fuelType', null, [
                'required' => true,
                'label' => 'Fuel Type',
                'attr' => [
                    'placeholder' => 'Fuel Type',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a fuel type',
                    ])
                ],
                'label_attr' => [
                    'class' => 'form-label',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
                'row_attr' => [
                    'class' => 'mt-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicles::class,
        ]);
    }
}
