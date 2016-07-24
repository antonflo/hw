<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Address entity
 */
class Address
{
    /** @var int */
    public $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $label;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $firstName;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $lastName;

    /**
     * @param string $label
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct($label, $firstName, $lastName)
    {
        $this->label = $label;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}
