<?php
namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use AppBundle\Entity\Address;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Form type for managing addresses
 */
class AddressForm extends FormType
{
    /** {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label', TextType::class, ['required' => true]);
        $builder->add('firstName', TextType::class, ['required' => true]);
        $builder->add('lastName', TextType::class, ['required' => true]);
    }

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'empty_data' => function (FormInterface $form) {
                return new Address(
                    $form->get('label')->getData(),
                    $form->get('firstName')->getData(),
                    $form->get('lastName')->getData()
                );
            },
            'data_class' => 'AppBundle\Entity\Address',
        ]);
    }
}