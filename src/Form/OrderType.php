<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('firstName', TextType::class, [
                'label' => "Prénom"
            ])
            ->add('date', null, [
                'widget' => 'single_text',
                'label' => 'Date de départ',
            ])
            ->add('enfants', IntegerType::class, [
                'label' => "Nombre d'enfant(s)"])
            ->add('animal', IntegerType::class, [
                'label' => "Nombre d'animal(aux)"
            ])
            ->add('term', IntegerType::class, [
                'label' => 'Période de séjour estimée (en années)'
            ])
            ->add('vaccins', CheckboxType::class, [
                'label' => "Vos vaccins sont-ils à jour ?",
                'required' => false,
            ])
            ->add('voiture', CheckboxType::class, [
                'label' => 'Aurez-vous une voiture ?',
                'required' => false,
            ])
            ->add('passeport', CheckboxType::class, [
                'label' => 'Votre passeport est-il à jour ?',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
