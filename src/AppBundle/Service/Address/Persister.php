<?php
namespace AppBundle\Service\Address;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Address;

/**
 * Address CRUD service
 *
 * @package AppBundle\Service
 */
class Persister
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Address $address
     */
    public function create(Address $address)
    {
        $this->em->persist($address);
        $this->updateDefault($address);
        $this->em->flush();
    }

    /**
     * @param Address $address
     */
    public function update(Address $address)
    {
        $this->updateDefault($address);
        $this->em->flush();
    }

    /**
     * Ensure there is one and only one default address
     *
     * @param Address $address
     */
    private function updateDefault(Address $address)
    {
//        if ($address->isDefault()) {
//
//        }
    }

    /**
     * @param Address $address
     */
    public function delete(Address $address)
    {
        $this->em->remove($address);
        $this->em->flush();
    }
}
