<?php

namespace MLBDagBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MLBDagBundle\Entity\DagEdge;
use MLBDagBundle\Entity\DagNode;

class LoadDagNodes implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i<10; $i++)
        {
            $temp = new DagNode('Node '.$i);
            $manager->persist($temp);
        }
        $manager->flush();
    }
}
