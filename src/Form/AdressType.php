<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', null, array(
                'label' => 'Nom',
            ))
            ->add('firstname', null, array(
                'label' => 'Prénom',
            ))
            ->add('email', EmailType::class, array(
                'label' => "Email",
            ))
            ->add('gender', ChoiceType::class, array(
                'label' => "Sexe",
                'choices'  => array('M.' => true, 'Mme' => false),
            ))
            ->add('phone_number', TelType::class, array(
                'label' => 'Numéro de téléphone',
                'trim' => true
            ))
            ->add('address', null,  array(
                'label' => 'Adresse'
            ))
            ->add('town', null, array(
                'label' => 'Ville'
            ))
            ->add('zipcode', null, array(
                'label' => 'Code postal'
            ))
            ->add('country', CountryType::class , array(
                'label' => 'Pays',
                'placeholder' => 'Selectionnez votre pays',
                'choices' => [
                    'France' => 'fr',
                    'England' => 'en',
                    'Belgique' => 'be',
                    'España' => 'es',
                    'Switzerland' => 'sw',
                    'Deutschland' => 'de'
                ],
                'preferred_choices' => ['fr', 'en', 'be', 'es', 'sw', 'de'],
                'help' => 'Nous vous rappelons que nos transporteurs ne livrent qu\'a l\'interieur de l\'union européene.'
            ))
            ->add('cardFile', FileType::class, array(
                'label' => 'Carte national d\'identité',
                'help' => 'Veuillez reunir le recto et le verso sur le même scan',
            ))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
