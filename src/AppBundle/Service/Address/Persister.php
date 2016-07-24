<?php
namespace AppBundle\Service\Address;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Address;
use Doctrine\ORM\EntityRepository;

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

    /** @var EntityRepository */
    private $repo;

    /**
     * Persister constructor.
     * @param EntityManagerInterface $em
     * @param EntityRepository $repo
     */
    public function __construct(EntityManagerInterface $em, EntityRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
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
     * @param Address $address
     */
    public function delete(Address $address)
    {
        $this->em->remove($address);
        $this->em->flush();
        if ($address->isDefault) {
            $this->setAnyDefault();
        }
    }

    /**
     * Ensure there is one and only one default address
     *
     * @param Address $address
     */
    private function updateDefault(Address $address)
    {
        /** @var Address[] $all */
        $all = $this->repo->findAll();
        if ($address->isDefault) {
            foreach ($all as $another) {
                if ($another !== $address) {
                    $another->isDefault = false;
                }
            }
        } else {
            // it is the one and only one address - so forecefully set it as default
            if (!$all || $address->id && 1 == count($all)) {
                $address->isDefault = true;
            }
        }
    }

    /**
     * Sets one random (if any) as default
     */
    private function setAnyDefault()
    {
        /** @var Address|null $any */
        $any = $this->repo->findOneBy([]);
        if ($any) {
            $any->isDefault = true;
            $this->em->flush();
        }
    }
}
