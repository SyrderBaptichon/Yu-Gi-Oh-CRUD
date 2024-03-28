<?php

namespace App\Form;

use App\Entity\Edition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_edition', TextType::class)
            ->add('date_edition', DateType::class, ['required' => false, 'years' => range(2010, 2025)])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer', // Modifier le label du bouton de sauvegarde
                'attr' => ['class' => 'button is-primary'] // Classes CSS pour le bouton
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Edition::class,
        ]);
    }
}
