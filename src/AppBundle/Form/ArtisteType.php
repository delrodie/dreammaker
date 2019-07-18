<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArtisteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le nom et prenoms de l'artiste", 'autocomplete'=>"off"], 'required'=> false
            ])
            ->add('pseudonyme', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"Le pseudonyme de l'artiste"]
            ])
            ->add('biographie', TextareaType::class,[
                'attr' =>['class'=>'form-control summernote', 'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;']
            ])
            ->add('manager', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"Les contacts téléphonique du manager de l'artiste"], 'required'=> false
            ])
            ->add('email', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"Email de l'artiste"], 'required'=> false
            ])
            ->add('website', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"Le site internet de l'artiste"], 'required'=> false
            ])
            ->add('genre', TextType::class,[
                'attr'=>['class'=>'form-control', 'data-role'=>'tagsinput', 'autocomplete'=>'off', 'placeholder'=>"Le genre musical de l'artiste"], 'required'=> false
            ])
            ->add('youtube', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"Le compte youtube de l'artiste"], 'required'=> false
            ])
            ->add('facebook', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"Le compte facebook de l'artiste"], 'required'=> false
            ])
            ->add('twitter', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"Le compte Tweeter de l'artiste"], 'required'=> false
            ])
            ->add('instagram', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"Le compte instagram de l'artiste"], 'required'=> false
            ])
            ->add('statut', CheckboxType::class,[
                'attr'=>['class'=>'custom-input-control'], 'required'=> false
            ])
            ->add('flag', ChoiceType::class,[
                'attr'=>['class'=>'form-control'],
                'choices'=>[
                    1 => 1,
                    2 => 1,
                    3 => 1,
                    4 => 4,
                    5 => 5
                ]
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
            'data_class' => 'AppBundle\Entity\Artiste'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_artiste';
    }


}
