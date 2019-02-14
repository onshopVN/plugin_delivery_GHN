<?php

namespace Plugin\GHNDelivery\Form\Type\Admin;

use Plugin\GHNDelivery\Entity\GHNConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

class ConfigType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('client_id', TextType::class, [
            'label' => 'ghn.config.client_id',
            'constraints' => [
                new NotBlank(),
                new Length(['max' => 255]),
            ],
        ])
            ->add('client_name', TextType::class, [
                'label' => 'ghn.config.client_name',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('token', TextType::class, [
                'label' => 'ghn.config.token',
                'constraints' => [
                    new NotBlank(),
                    new Regex(['pattern' => '/^[^\s ]+$/u', 'message' => 'form_error.not_contain_spaces'])
                ]
            ])
            ->add('weight', NumberType::class, [
                'label' => 'ghn.config.weight',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 1])
                ]
            ])
            ->add('payment_type', ChoiceType::class, [
                'label_attr' => ['class' => 'col-form-label'],
                'label' => 'ghn.config.payment_type',
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'ghn.config.payment_type.seller' => GHNConfig::PAYMENT_TYPE_SELLER,
                    'ghn.config.payment_type.buyer' => GHNConfig::PAYMENT_TYPE_BUYER
                ],
                'constraints' => []
            ])
            ->add('callback_url', UrlType::class, [
                'help' => 'ghn.config.callback_url.help',
                'label' => 'ghn.config.callback_url',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('note_code', ChoiceType::class, [
                'label_attr' => ['class' => 'col-form-label'],
                'label' => 'ghn.config.note_code',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'CHOTHUHANG' => 'CHOTHUHANG',
                    'CHOXEMHANGKHONGTHU' => 'CHOXEMHANGKHONGTHU',
                    'KHONGCHOXEMHANG' => 'KHONGCHOXEMHANG',
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('insurance_fee', NumberType::class, [
                'label' => 'ghn.config.insurance_fee',
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 0, 'max' => 10000000])
                ]
            ])
            ->add('check_main_bank_account', ChoiceType::class, [
                'label_attr' => ['class' => 'col-form-label'],
                'label' => 'ghn.config.checkout',
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'ghn.config.checkout.bank_transfer' => true,
                    'ghn.config.checkout.cod' => false
                ],
            ])
            ->add('is_credit_create', ChoiceType::class, [
                'label_attr' => ['class' => 'col-form-label'],
                'label' => 'ghn.config.wallet',
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'ghn.config.wallet.yes' => true,
                    'ghn.config.wallet.no' => false
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GHNConfig::class,
        ]);
    }
}
