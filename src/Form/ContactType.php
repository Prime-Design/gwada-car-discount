<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre Nom',
                'required' => true,
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre Nom',
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre Email',
                'required' => true,
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'required' => true,
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'csrf_protection' => true, // CSRF est activé par défaut
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'contact_item', // Identifiant unique pour le CSRF
        ]);
    }
}


