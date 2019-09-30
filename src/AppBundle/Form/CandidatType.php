<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CandidatType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le pseudo de l'artiste"]
            ])
            ->add('nom', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le nom de l'artiste"]
            ])
            ->add('prenoms', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Les prenoms de l'artiste"]
            ])
            /*->add('contact', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le contact"]
            ])*/
            ->add('biographie', TextareaType::class,[
                'attr'=>['class'=>'form-control summernote', 'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;']
            ])
            ->add('code', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le code de vote"]
            ])
            ->add('genre', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Genre musical"]
            ])
            ->add('facebook', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le compte facebook"], 'required'=>false
            ])
            ->add('instagram', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le compte instagram"], 'required'=>false
            ])
            ->add('twitter', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le compte twitter"], 'required'=>false
            ])
            ->add('youtube', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le lien youtube "], 'required'=>false
            ])
            ->add('pointJury', IntegerType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le point du Jury"], 'required'=>false
            ])
            ->add('pointUreport', IntegerType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le point Ureport"], 'required'=>false
            ])
            /*->add('pointWeb', IntegerType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le point du Web"], 'required'=>false
            ])*/
            ->add('pointFacebook', IntegerType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le point des votes facebook"], 'required'=>false
            ])
            /*->add('total', IntegerType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>""], 'required'=>false
            ])*/
            /*->add('moyenne', IntegerType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>""], 'required'=>false
            ])
            ->add('pourcentage', IntegerType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>""], 'required'=>false
            ])*/
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
            'data_class' => 'AppBundle\Entity\Candidat'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_candidat';
    }


}
