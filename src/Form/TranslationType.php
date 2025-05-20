<?php

namespace App\Form;

use App\Entity\Language;
use App\Entity\Translation;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class TranslationType extends AbstractType
{
    private const LANGUAGE_DEFAULT = 'DE';

    /*
     * Builds the translation form, shows all languages except german and uses the iso code as select value
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'label' => 'Sprache',
                'placeholder' => 'Sprache wählen',
                'choice_label' => 'name',
                'choice_value' => function (?Language $language): string {
                    return $language ? $language->getIsoCode() : '';
                },
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('lang')
                        ->where('lang.iso_code != :iso_code')
                        ->setParameter('iso_code', self::LANGUAGE_DEFAULT)
                        ->orderBy('lang.name', 'ASC');
                },
                'constraints' => new NotNull()
            ])
            ->add('translation', TextareaType::class, [
                'mapped' => false,
                'label' => 'Übersetzung',
                'attr' => ['rows' => 5],
                'constraints' => new NotNull()
            ])
            ->add('origin_id', HiddenType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotNull(),
                    new Positive()
                ]
            ])
            ->add('translate', ButtonType::class, [
                'label' => 'übersetzen',
                'attr' => ['class' => 'bg-olive']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'speichern',
                'attr' => ['class' => 'bg-olive']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Translation::class
        ]);
    }
}