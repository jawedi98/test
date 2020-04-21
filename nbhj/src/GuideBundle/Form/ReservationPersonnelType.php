<?php

namespace GuideBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationPersonnelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateDebut',DateType::class ,['widget' => 'single_text' , 'format' => 'yyyy-MM-dd'])->add('dateFin',DateType::class ,['widget' => 'single_text' , 'format' => 'yyyy-MM-dd'])->add('user',  EntityType::class,array(
            'class'=>'AppBundle:User',
            'choice_label'=>'nom',
            'multiple'=>false))->add('guide', EntityType::class,array(
            'class'=>'GuideBundle:Guide',
            'choice_label'=>'nom',
            'multiple'=>false));
        $builder->add('valider' ,SubmitType::class, ['attr'=>['formnovalidate'=>'formnovalidate']]);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GuideBundle\Entity\ReservationPersonnel'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'guidebundle_reservationpersonnel';
    }


}
