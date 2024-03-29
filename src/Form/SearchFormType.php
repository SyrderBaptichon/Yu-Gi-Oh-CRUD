<?php
// src/Form/SearchFormType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', TextType::class, [
                'label' => ' ',
                'required' => false, // Le champ de recherche n'est pas obligatoire
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Rechercher', // Modifier le label du bouton de sauvegarde
                'attr' => ['class' => 'button is-primary'] // Classes CSS pour le bouton
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Définir ici les options par défaut
        ]);
    }
}

