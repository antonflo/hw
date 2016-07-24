<?php
namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use AppBundle\Entity\Address;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

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
        $builder->add('phone', TextType::class, ['required' => true]);
        $builder->add('street1', TextType::class, ['required' => true]);
        $builder->add('street2', TextType::class, ['required' => false]);
        $builder->add('city', TextType::class, ['required' => true]);
        $builder->add('state', TextType::class, ['required' => false]);
        $builder->add('zip', TextType::class, ['required' => false]);
        $builder->add('country', TextType::class, ['required' => true]);
        $builder->add('isDefault', CheckboxType::class, ['required' => false]);
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
                    $form->get('lastName')->getData(),
                    $form->get('phone')->getData(),
                    $form->get('street1')->getData(),
                    $form->get('city')->getData(),
                    $form->get('country')->getData()
                );
            },
            'data_class' => 'AppBundle\Entity\Address',
        ]);
    }
}
