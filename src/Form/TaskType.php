<?php

namespace App\Form;

use App\Entity\Etiquette;
use App\Entity\Task;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType; 

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' =>'Description'

            ])
            ->add('statut', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Statut',
                'choices' => [
                    'Pas commencé' => 'Pas commencé',
                    'En cours' => 'En cours',
                    'Fait' => 'Fait',
                ]
            ])
            ->add('priority', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Priorité',
                'choices' => [
                    'Faible' => 'Faible',
                    'Moyenne' => 'Moyenne',
                    'Élevée' => 'Élevée',
                ]
            ])
            ->add('etiquette', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Étiquette',
                'choices' => [
                    'Urgent' => 'Urgent',
                    'Important' => 'Important',
                    'Personnel' => 'Personnel',
                    'Professionnel' => 'Professionnel',
                    'Maison' => 'Maison',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
