<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserSettingsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user_password = $options['data']->getPassword();
        $builder
            ->add('email')
            // ->add('firstName')
            // ->add('lastName')
            // ->add('phone')
            // ->add('address')
            ->add('currentPassword', PasswordType::class, ['mapped' => false])
            ->add('newPassword1', PasswordType::class, ['mapped' => false])
            ->add('newPassword2', PasswordType::class, ['mapped' => false])
            ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}