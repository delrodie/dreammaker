<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le titre de l'évènement", 'autocomplete'=>"off"]
            ])
            ->add('contenu', TextareaType::class,[
                'attr' =>['class'=>'form-control summernote']
            ])
            //->add('resume')
            ->add('tags', TextType::class,[
                'attr'=>['class'=>'form-control', 'data-role'=>'tagsinput', 'placeholder'=>'Les mots clés']
            ])
            ->add('statut', CheckboxType::class,[
                'attr'=>['class'=>'custom-input-control'], 'required'=> false
            ])
            ->add('dateEvent', TextType::class,[
                'attr'=>['class'=>'form-control datepicker', 'placeholder'=>"Date debut de l'event", 'autocomplete'=>"off"]
            ])
            ->add('imageFile', VichImageType::class,[
                'required' => false,
                'allow_delete' => true,
                'label' => '.',
            ])
            //->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_event';
    }


}
