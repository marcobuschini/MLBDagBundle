<?php

namespace MLB\DagBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MLBDagBundle\Entity\DagEdge;
use MLBDagBundle\Entity\DagNode;

class LoadDagEdges implements FixtureInterface, DependentFixtureInterface
{
    private $node = array(10);

    public function getDependencies()
    {
        return array('MLBDagBundle\DataFixtures\ORM\LoadDagNodes');
    }

    public function load(ObjectManager $manager)
    {
        $repoNode = $manager->getRepository('MLBDagBundle\Entity\DagNode');
        
        $nodes = $repoNode->findAll();
        foreach ($nodes as $node) {
            $nodeArray[] = $node;
        }

        $repoEdge = $manager->getRepository('MLBDagBundle\Entity\DagEdge');
        
        // First graph
        $repoEdge->createEdge($nodeArray[0], $nodeArray[1]);
        $repoEdge->createEdge($nodeArray[0], $nodeArray[2]);
        $repoEdge->createEdge($nodeArray[0], $nodeArray[3]);

        $repoEdge->createEdge($nodeArray[1], $nodeArray[2]);
        $repoEdge->createEdge($nodeArray[2], $nodeArray[3]);
        $repoEdge->createEdge($nodeArray[3], $nodeArray[4]);

        // Second graph
        $repoEdge->createEdge($nodeArray[5], $nodeArray[6]);
        $repoEdge->createEdge($nodeArray[5], $nodeArray[7]);
        $repoEdge->createEdge($nodeArray[5], $nodeArray[8]);

        $repoEdge->createEdge($nodeArray[6], $nodeArray[7]);
        $repoEdge->createEdge($nodeArray[7], $nodeArray[8]);
        $repoEdge->createEdge($nodeArray[8], $nodeArray[9]);

        // Connect the two graphs
        //$repoEdge->createEdge($nodeArray[4], $nodeArray[5]);
        
        // Disconnect the two graphs
        //$repoEdge->deleteEdgeByEnds($nodeArray[4], $nodeArray[5]);
    }
}
