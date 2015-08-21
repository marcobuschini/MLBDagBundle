<?php

namespace MLB\DagBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DagEdgeRepository
 *
 */
class DagEdgeRepository extends EntityRepository
{
    public function createEdge(DagNode $start, DagNode $end)
    {
        // Check if the edge already exists
        $direct = $this->findDirectEdge($start, $end);

        if($direct != null)
            return;

        $em = $this->getEntityManager();

        // Check for a circular reference, step 1
        if($start->getId() == $end->getId())
            throw new CircularRelationException();

        // Check for a circular reference, step 2
        $dql =  'SELECT e'.
                '  FROM MLBDagBundle\Entity\DagEdge e'.
                ' WHERE e.start_node = :end'.
                '   AND e.end_node = :start';
        $query = $em->createQuery($dql);
        $query->setParameter('start', $start)
              ->setParameter('end', $end);

        $circular = $query->getResult();
        
        if(count($circular) > 0)
            throw new CircularRelationException();

        // Create new edge
        $edge = new DagEdge();
        $edge->setIncomingEdge($edge)
             ->setDirectEdge($edge)
             ->setOutgoingEdge($edge)
             ->setStartNode($start)
             ->setEndNode($end)
             ->setHops(0);

        $em->persist($edge);
        $em->flush();

        // Step 1: A to B incoming edges
        $dql = 'SELECT e '.
               '  FROM MLBDagBundle\Entity\DagEdge e '.
               ' WHERE e.end_node = :start';
        $query = $em->createQuery($dql);
        $query->setParameter('start', $start);

        $steps = $query->getResult();
        foreach($steps as $step)
        {
            $outgoing = new DagEdge();
            $outgoing->setIncomingEdge($step)
                ->setDirectEdge($edge)
                ->setOutgoingEdge($edge)
                ->setStartNode($step->getStartNode())
                ->setEndNode($end)
                ->setHops($step->getHops()+1);
            
            $em->persist($outgoing);
        }
        $em->flush();
        
        // Step 2: A to B outgoing edges
        $dql = 'SELECT e '.
               '  FROM MLBDagBundle\Entity\DagEdge e'.
               ' WHERE e.start_node = :end';
        $query = $em->createQuery($dql);
        $query->setParameter('end', $end);

        $steps = $query->getResult();
        foreach($steps as $step)
        {
            $outgoing = new DagEdge();
            $outgoing->setIncomingEdge($edge)
                ->setDirectEdge($edge)
                ->setOutgoingEdge($step)
                ->setStartNode($start)
                ->setEndNode($step->getEndNode())
                ->setHops($step->getHops()+1);
            
            $em->persist($outgoing);
        }
        $em->flush();
        
        // Step 3: A's incoming to B's end nodes outgoing edges
        $dql = 'SELECT A.id ida, A.hops ahops, B.id idb, B.hops bhops'.
               '  FROM MLBDagBundle\Entity\DagEdge A'.
               '  JOIN MLBDagBundle\Entity\DagEdge B'.
               ' WHERE A.start_node = :end'.
               '   AND B.end_node = :start';
        $query = $em->createQuery($dql);
        $query->setParameter('start', $start)
              ->setParameter('end', $end);

        $steps = $query->getResult();
        $repoEdge = $em->getRepository('MLBDagBundle\Entity\DagEdge');

        foreach($steps as $step)
        {
            $a = $repoEdge->findOneById($step['ida']);
            $b = $repoEdge->findOneById($step['idb']);
            $outgoing = new DagEdge();
            $outgoing->setIncomingEdge($a)
                ->setDirectEdge($edge)
                ->setOutgoingEdge($b)
                ->setStartNode($start)
                ->setEndNode($end)
                ->setHops($step['ahops']+$step['bhops']+1);
            
            $em->persist($outgoing);
        }
        $em->flush();
    }

    public function findDirectEdge(DagNode $start, DagNode $end)
    {
        $em = $this->getEntityManager();
        $dql = 'SELECT e'.
               '  FROM MLBDagBundle\Entity\DagEdge e'.
               ' WHERE e.start_node = :start'.
               '   AND e.end_node = :end'.
               '   AND e.hops = :hops';
        $query = $em->createQuery($dql);
        $query->setParameter('start', $start);
        $query->setParameter('end', $end);
        $query->setParameter('hops', 0);
        
        $edge = $query->getOneOrNullResult();
        
        return $edge;
    }
    
    public function findEdges(DagNode $start, DagNode $end)
    {
        $em = $this->getEntityManager();
        $dql = 'SELECT e'.
               '  FROM MLBDagBundle\Entity\DagEdge e'.
               ' WHERE e.start_node = :start'.
               '   AND e.end_node = :end'.
               ' ORDER BY e.hops';

        $query = $em->createQuery($dql);
        $query->setParameter('start', $start);
        $query->setParameter('end', $end);

        $result = $query->getResult();
        
        return $result;
    }

    public function findAllDirectEdges()
    {
        $em = $this->getEntityManager();
        $dql = 'SELECT e'.
               '  FROM MLBDagBundle\Entity\DagEdge e'.
               ' WHERE e.hops = 0';

        $query = $em->createQuery($dql);

        return $query->getResult();
    }

    public function deleteEdgeByEnds(DagNode $start, DagNode $end)
    {
        $direct = $this->findDirectEdge($start, $end);
        if($direct == null)
            throw new EdgeDoesNotExistException();
        $this->deleteEdge($direct);
    }
    
    public function deleteEdge(DagEdge $edge)
    {
        
        $em = $this->getEntityManager();
        // Check if direct edge exists
        $dql =  'SELECT e'.
                '  FROM MLBDagBundle\Entity\DagEdge e'.
                ' WHERE e.id = :id'.
                '   AND e.hops = :hops';
        $query = $em->createQuery($dql);
        $query->setParameter('id', $edge->getId());
        $query->setParameter('hops', 0);
        
        $direct = $query->getOneOrNullResult();
        
        if($direct == null)
            throw new EdgeDoesNotExistException();
        
        $em->getConnection()->beginTransaction();
        
        // Step 1: find derived edges inserted by direct edges
        $dql = 'SELECT e'.
               '  FROM MLBDagBundle\Entity\DagEdge e'.
               ' WHERE e.direct_edge = :direct';
        $query = $em->createQuery($dql);
        $query->setParameter('direct', $edge);
        
        $purgeList = $query->getResult();
        
        do {
            $rowCount = 0;
            
            $dql = 'SELECT e'.
                   '  FROM MLBDagBundle\Entity\DagEdge e'.
                   ' WHERE e.hops > 0'.
                   '   AND (e.incoming_edge IN (:purgelist)'.
                   '   AND e.outgoing_edge IN (:purgelist))'.
                   '   AND e NOT IN (:purgelist)';
            $query = $em->createQuery($dql);
            $query->setParameter('purgelist', $purgeList);
            $purgeSubList = $query->getResult();
            $rowCount = count($purgeSubList);
            array_merge($purgeList, $purgeSubList);
        } while($rowCount != 0);
        
        $dql = 'DELETE'.
               '  FROM MLBDagBundle\Entity\DagEdge e'.
               ' WHERE e IN (:purgelist)';
        $query = $em->createQuery($dql);
        $query->setParameter('purgelist', $purgeList);
        $query->getResult();
        
        $em->remove($edge);

        $em->getConnection()->commit();

        $em->flush();
    }
}
