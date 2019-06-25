<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->reglement =$options['reglement'];
        $reglement = $this->reglement;

        $builder
            ->add('titre', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"Le titre du paragraphe"]
            ])
            ->add('contenu', TextareaType::class,[
                'attr' =>['class'=>'form-control summernote']
            ])
            ->add('statut', CheckboxType::class,[
                'attr'=>['class'=>'custom-input-control'], 'required'=>false
            ])
            //->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('reglement', EntityType::class,[
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off'
                ),
                'class' => 'AppBundle:Reglement',
                'query_builder' =>  function(EntityRepository $er) use($reglement){
                    return $er->findOnly($reglement);
                },
                'choice_label'  => 'titre',
            ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Item',
            'reglement' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_item';
    }


}
