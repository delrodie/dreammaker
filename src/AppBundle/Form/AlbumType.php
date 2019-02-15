<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AlbumType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class,[
                'choices'=>[
                    'ALBUM' => 'Album',
                    'SINGLE' => 'Single'
                ],
                'attr'=>['class'=>'form-control']
            ])
            ->add('titre', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le titre l'album", 'autocomplete'=>'off'], 'required'=> true
            ])
            ->add('compositeur', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le(s) compositeur(s) de l'album", 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('choeur', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Les choeurs ayant intervenus", 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('arrangeur', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"L'(les) arrangeur(s) de l'album", 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('producteur', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le(s) producteur(s) de l'album", 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('mixage', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>'Le mixage', 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('master', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>'Le master', 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('distribution', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>'La distribution', 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('spotify', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le lien spotify de vente de l'album", 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('deezer', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le lien deezer de vente de l'album", 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('itunes', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le lien itunes de vente de l'album", 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('googlePlay', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le lien Google Play de vente de l'album", 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('amazon', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le lien Amazon de vente de l'album", 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('iftypay', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Le lien de vente de l'album ", 'autocomplete'=>'off'], 'required'=> false
            ])
            ->add('statut', CheckboxType::class, [
                'attr'=>['class'=>'costum-input-control'], 'required'=> false
            ])
            ->add('imageFile', VichImageType::class,[
                'required' => false,
                'allow_delete' => true,
                'label' => '.',
            ])
            //->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('artiste', EntityType::class,[
                'attr'=>['class'=>'form-control select2'],
                'class'=> 'AppBundle:Artiste',
                'query_builder'=> function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label' =>'pseudonyme'
            ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Album'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_album';
    }


}
