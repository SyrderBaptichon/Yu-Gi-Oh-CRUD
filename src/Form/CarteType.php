<?php

namespace App\Form;

use App\Entity\Carte;
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
            ->add('carte_attribut', ChoiceType::class, [
                'choices' => [
                    'Lumière' => 'lumière',
                    'Feu' => 'feu',
                    'Ténèbres' => 'ténèbres',
                    'Vent' => 'vent',
                    'Terre' => 'terre',
                    'Eau' => 'eau',
                ],
                'required' => false,
            ])
            ->add('carte_categorie', ChoiceType::class, [
                'choices' => [
                    'Monstre' => 'Monstre',
                    'Magie' => 'Magie',
                    'Piège' => 'Piège',
                ],
            ])
            ->add('carte_niveau', IntegerType::class, [
                'required' => false,
            ])
            ->add('carte_image', URLType::class, [
                'label' => 'Image',
                'required' => false,
                'empty_data' => 'https://data.pixiz.com/output/user/frame/preview/api/big/0/7/6/3/2063670_b8d7e.jpg' // Valeur par défaut si aucun URL n'est fourni
            ])
            ->add('carte_type', ChoiceType::class, [
                'choices' => [
                    'TONNERRE' => 'TONNERRE',
                    'ELFE' => 'ELFE',
                    'MACHINE' => 'MACHINE',
                    'GUERRIER' => 'GUERRIER',
                    'DRAGON' => 'DRAGON',
                    'BÊTE' => 'BÊTE',
                    'REPTILE' => 'REPTILE',
                    'JEU RAPIDE' => 'JEU RAPIDE',
                    'AQUA' => 'AQUA',
                    'BÊTE-GUERRIER' => 'BÊTE-GUERRIER',
                    'ROCHER' => 'ROCHER',
                    'PYRO' => 'PYRO',
                    'RITUEL' => 'RITUEL',
                    'POISSON' => 'POISSON',
                    'PLANTE' => 'PLANTE',
                    'CONTRE' => 'CONTRE',
                    'BÊTE AILÉE' => 'BÊTE AILÉE',
                    'MAGICIEN' => 'MAGICIEN',
                    'ÉQUIPEMENT' => 'ÉQUIPEMENT',
                    'TERRAIN' => 'TERRAIN',
                    'SERPENT DE MER' => 'SERPENT DE MER',
                    'NORMAL' => 'NORMAL',
                    'CYBERSE' => 'CYBERSE',
                    'PSYCHIQUE' => 'PSYCHIQUE',
                    'ZOMBIE' => 'ZOMBIE',
                    'CONTINU' => 'CONTINU',
                    'DINOSAURE' => 'DINOSAURE',
                    'DÉMON' => 'DÉMON',
                ],
                'required' => false,
            ])
            ->add('carte_specificite', ChoiceType::class, [
                'choices' => [
                    'FUSION' => 'FUSION',
                    'UNION' => 'UNION',
                    'AUCUNE' => 'AUCUNE',
                    'PENDULE' => 'PENDULE',
                    'XYZ' => 'XYZ',
                    'SYNCHRO' => 'SYNCHRO',
                    'RITUEL' => 'RITUEL',
                    'TOON' => 'TOON',
                    'LIEN' => 'LIEN',
                    'SYNTONISEUR' => 'SYNTONISEUR',
                    'GÉMEAU' => 'GÉMEAU',
                    'FLIP' => 'FLIP',
                    'EFFET' => 'EFFET',
                ],
                'required' => false,
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
