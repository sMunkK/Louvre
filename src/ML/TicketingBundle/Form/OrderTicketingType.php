<?php

namespace ML\TicketingBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderTicketingType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jourVisite',      DateType::class, array(
                'label' => 'Veuillez sélectionner le jour de la visite : ',
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker'),
                'format' => 'dd-MM-yyyy'))
            ->add('email',     EmailType::class, array('label' => 'Veuillez entrer votre email : '))
            ->add('typeBillet', ChoiceType::class, array('label' => 'Veuillez sélectionner un type de réservation : ',
                'choices' => array(
                    'Journée' => 1,
                    'Demi-Journée' => 0
                ),
            ))
            ->add('nombreBillets',   IntegerType::class, array('label' => 'Quels nombres de billets désirez-vous acheter : '))
            ->add('save',      SubmitType::class, array('label' => 'Suivant'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ML\TicketingBundle\Entity\OrderTicketing'
        ));
    }

}
