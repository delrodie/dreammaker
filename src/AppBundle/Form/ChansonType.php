<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChansonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->album =$options['album'];
        $album = $this->album;
        $builder
            ->add('piste', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"Le numéro de la piste de l'artiste"]
            ])
            ->add('titre', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"Le titre de la chanson"]
            ])
            ->add('duree', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>"La durée de la chanson"]
            ])
            ->add('statut', CheckboxType::class,[
                'attr'=>['class'=>'custom-input-control'], 'required'=>false
            ])
            //->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('album', EntityType::class,[
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off'
                ),
                'class' => 'AppBundle:Album',
                'query_builder' =>  function(EntityRepository $er) use($album){
                    return $er->findAlbum($album);
                },
                'choice_label'  => 'titre',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Chanson',
            'album' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_chanson';
    }


}
