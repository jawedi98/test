<?php

namespace ShopBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre', TextType::class, array(
            'label' => 'Titre',
            'attr' => ['id' => 'titre2','class' => 'form-control']
        ))
            ->add('contenu', TextareaType::class, array(
                'label' => 'Contenu',
                'attr' => ['class' => 'form-control' ]
            ))->add('categorie',EntityType::class,
        ['class'=>'ShopBundle\Entity\CategorieQ',
            'choice_label'=>'nom',
            'multiple'=>false,
            'expanded'=>false
        ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ShopBundle\Entity\Question'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'shopbundle_question';
    }


}
