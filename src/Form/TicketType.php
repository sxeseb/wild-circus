<?php

namespace App\Form;

use App\Entity\Price;
use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $prices = $options['prices'];
        $builder
            ->add('quantity', NumberType::class, [
                'html5' => true
            ])
            ->add('price', EntityType::class, [
                'class' => Price::class,
                'choice_label' => 'name',
                'choices' => $prices
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
        $resolver->setRequired('prices');
    }
}
