<?php


namespace GuideBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ReservationPersonnelRepository extends  EntityRepository
{

    public function resmyFind($id)
    {
        $qb=$this->getEntityManager()->createQuery( "select L from GuideBundle:ReservationPersonnel L where L.id_user='$id' ");
        return $query = $qb->getResult();


    }
    public function countFav($id)
    {
        $sql="select l.nom,l.prenom,l.image ,f.id ,f.dateFin,f.dateDebut  from GuideBundle:ReservationPersonnel f join f.guide l join f.user u where u.id='".$id."'  ";

        $qb=$this->getEntityManager()->
        createQuery($sql);
        $liste=$qb->getResult();
        return $liste;
    }
}