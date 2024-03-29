<?php

namespace App\Form;

use App\Entity\Carte;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('carte_nom', TextType::class)
            ->add('carte_attribut', EntityType::class, [
                'class' => Carte::class,
                'choice_label' => 'carte_attribut', // Affiche le nom de la carte dans la liste
                'choice_value' => 'carte_attribut', // Transmet le numéro de la carte lors de la soumission
            ])
            ->add('carte_categorie', EntityType::class, [
                'class' => Carte::class,
                'choice_label' => 'carte_categorie', // Affiche le nom de la carte dans la liste
                'choice_value' => 'carte_categorie',// Transmet le numéro de la carte lors de la soumission
                'required' => 'false',
            ])
            ->add('carte_niveau', IntegerType::class, [
                'required' => false,
            ])
            ->add('carte_image', URLType::class, [
                'label' => 'Image',
                'required' => false,
                'empty_data' => 'https://data.pixiz.com/output/user/frame/preview/api/big/0/7/6/3/2063670_b8d7e.jpg' // Valeur par défaut si aucun URL n'est fourni
            ])
            ->add('carte_type',EntityType::class, [
                'class' => Carte::class,
                'choice_label' => 'carte_type', // Affiche le nom de la carte dans la liste
                'choice_value' => 'carte_type',// Transmet le numéro de la carte lors de la soumission
                'required' => 'false',
            ])
            ->add('carte_specificite', EntityType::class, [
                'class' => Carte::class,
                'choice_label' => 'carte_specificite', // Affiche le nom de la carte dans la liste
                'choice_value' => 'carte_specificite',// Transmet le numéro de la carte lors de la soumission
                'required' => 'false',
                'empty_data' =>' '
            ])
            ->add('carteATK', IntegerType::class, [
                'required' => false,
            ])
            ->add('carteDEF', IntegerType::class, [
                'required' => false,
            ])
            ->add('carte_description', TextareaType::class, [
                'required' => false,
            ]) // Utilisation de TextareaType pour carte_description
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer', // Modifier le label du bouton de sauvegarde
                'attr' => ['class' => 'button is-primary'] // Classes CSS pour le bouton
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Carte::class,
        ]);
    }
}
