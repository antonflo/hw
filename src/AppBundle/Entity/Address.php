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
     * @var string
     * @Assert\NotBlank()
     */
    public $phone;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $street1;

    /**
     * @var string|null
     */
    public $street2;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $city;

    /**
     * @var string|null
     */
    public $state;

    /**
     * @var string|null
     */
    public $zip;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $country;

    /**
     * @var bool
     */
    public $isDefault = true;

    /**
     * @param string $label
     * @param string $firstName
     * @param string $lastName
     * @param string $phone
     * @param string $street1
     * @param string $city
     * @param string $country
     */
    public function __construct($label, $firstName, $lastName, $phone, $street1, $city, $country)
    {
        $this->label = $label;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->street1 = $street1;
        $this->city = $city;
        $this->country = $country;
    }
}
