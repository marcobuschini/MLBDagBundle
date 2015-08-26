<?php

namespace MLB\DagBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MLB\DagBundle\Entity\DagEdge;
use MLB\DagBundle\Entity\DagNode;

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
