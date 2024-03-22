<?php

namespace App\Form;

use App\Entity\Carte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('carte_attribut', TextType::class)
            ->add('carte_categorie', TextType::class)
            ->add('carte_niveau', IntegerType::class)
            ->add('carte_image', UrlType::class)
            ->add('carte_type', TextType::class)
            ->add('carte_specificite', TextType::class)
            ->add('carteATK', IntegerType::class)
            ->add('carteDEF', IntegerType::class)
            ->add('carte_description', TextType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Carte::class,
        ]);
    }
}
