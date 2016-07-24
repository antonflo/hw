<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Simplified form type
 */
class FormType extends AbstractType
{
    /**
     * Configures common options for form types
     *
     * Disables CSRF protection built-in in the form
     * Allows extra fields
     * All this makes it easier to handle form submissions populated not by Symfony Form Builder
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}