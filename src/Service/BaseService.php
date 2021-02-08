<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use \Exception;

class BaseService
{
    /**
     * @var EntityManagerInterface $em
     */
    protected $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param object $object
     * @return object
     * @throws Exception
     */
    protected function saveObject(object $object): ?object
    {
        try {
            $this->em->persist($object);
            $this->em->flush();

            return $object;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param object $object
     * @return bool|null
     * @throws Exception
     */
    protected function removeObject(object $object): ?bool
    {
        try {
            $this->em->remove($object);
            $this->em->flush();

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}