<?php

namespace App\Form;

use App\Entity\Origin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class OriginType extends AbstractType
{
    /*
     * Builds the form to create a new origin text
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('txt', TextareaType::class, [
                'label' => 'Text',
                'attr' => ['rows' => 5],
                'constraints' => new NotNull()
            ])
            ->add('save', SubmitType::class, [
                'label' => 'speichern'
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Origin::class
        ]);
    }
}