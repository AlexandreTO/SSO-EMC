<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class)
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => ['label' => 'Password'],
            'second_options' => ['label' => 'Confirm Password']
        ])
        ->add('firstName', TextType::class)
        ->add('lastName', TextType::class)
        ->add('speciality', TextType::class)
        ->add('address1', TextType::class)
        ->add('address2', TextType::class, ['required' => false])
        ->add('address3', TextType::class, ['required' => false])
        ->add('zipcode', TextType::class)
        ->add('city', TextType::class)
        ->add('state', TextType::class, ['required' => false])
        ->add('country', TextType::class)
        ->add('website', TextType::class, ['required' => false])
        ->add('phone1', TextType::class, ['required' => false])
        ->add('phone2', TextType::class, ['required' => false])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
