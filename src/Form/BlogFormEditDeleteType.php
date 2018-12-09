<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BlogFormEditDeleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => '.',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form_title_class', 'placeholder' => 'Headline')
            ])
            ->add('description', TextareaType::class, [
                'label' => '.',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form_description_class', 'placeholder' => 'Description')
            ])
            ->add('create', SubmitType::class, [
                'label' => 'Send',
                'attr' => array('class' => 'form_subl_class')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
