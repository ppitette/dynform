<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfonycasts\DynamicForms\DependentField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Particulier' => 'individual',
                    'Entreprise' => 'company',
                ],
                'expanded' => true,
            ])
            ->addDependent('firstname', 'type', function (DependentField $field, ?string $type) {
                if ($type != 'individual') {
                    return;
                }
                $field->add(TextType::class, [
                    'label' => 'Prénom',
                ]);
            })
            ->addDependent('lastname', 'type', function (DependentField $field, ?string $type) {
                if ($type != 'individual') {
                    return;
                }
                $field->add(TextType::class, [
                    'label' => 'Nom',
                ]);
            })
            ->addDependent('company_name', 'type', function (DependentField $field, ?string $type) {
                if ($type != 'company') {
                    return;
                }
                $field->add(TextType::class, [
                    'label' => 'Raison sociale',
                ]);
            })
            ->addDependent('siret', 'type', function (DependentField $field, ?string $type) {
                if ($type != 'company') {
                    return;
                }
                $field->add(TextType::class, [
                    'label' => 'SIRET',
                ]);
            })
            ->add('address', TextType::class, [
                'label' => 'Adresse',
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('plan', ChoiceType::class, [
                'choices' => [
                    'Gratuit' => 'free',
                    'Premium' => 'premium',
                ],
                'expanded' => true,
            ])
            ->addDependent('payment', 'plan', function (DependentField $field, ?string $plan) {
                if ($plan != 'premium') {
                    return;
                }
                $field->add(ChoiceType::class, [
                    'label' => 'Paiement',
                    'choices' => [
                        'Carte de crédit' => 'credit_card',
                        'Virement' => 'iban',
                    ],
                    'expanded' => true,
                ]);
            })
            ->addDependent('credit_card', 'payment', function (DependentField $field, ?string $payment) {
                if ($payment != 'credit_card') {
                    return;
                }
                $field->add(TextType::class, [
                    'label' => 'Numéro de carte',
                ]);
            })
            ->addDependent('iban', 'payment', function (DependentField $field, ?string $payment) {
                if ($payment != 'iban') {
                    return;
                }
                $field->add(TextType::class, [
                    'label' => 'IBAN',
                ]);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
