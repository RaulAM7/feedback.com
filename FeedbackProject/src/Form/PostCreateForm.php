<?php
// src/Form/YourEntityType.php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostCreateForm extends AbstractType
{
    // En el método buildForm definimos cómo se construye el formulario
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('type', ChoiceType::class, [  // 'type' debe coincidir con el nombre de la propiedad
                'choices' => Post::getTypeChoices(),  // Las opciones disponibles
                'multiple' => false,  // false = solo una opción seleccionable
                'expanded' => true,   // true = radio buttons, false = dropdown
                'label' => 'Tipo',    // Etiqueta que verá el usuario
                'required' => true,   // El campo es obligatorio
            ])
            ->add('status', ChoiceType::class,   [
                'choices' => Post::getStatusChoices(),
                'mutliple' => false,
                'expanded' => true,
                'label'=> 'Tipo',
                'required'=> true,
            ]);
    }

    // Configura las opciones del formulario
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,  // Vincula el formulario con la entidad
        ]);
    }

}