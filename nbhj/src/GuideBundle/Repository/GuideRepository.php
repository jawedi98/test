<?php


namespace GuideBundle\Repository;


use Doctrine\ORM\EntityRepository;

class GuideRepository extends  EntityRepository
{

    public function myFind($id)
    {
        $qb=$this->getEntityManager()->createQuery( "select L from GuideBundle:Guide L where L.id='$id' ");
        return $query = $qb->getResult();


    }
}