<?php
namespace MLB\DagBundle\Tests\Doctrine;

use MLB\DagBundle\DataFixtures\ORM\LoadDagNodes;
use MLB\DagBundle\DataFixtures\ORM\LoadDagEdges;
use MLB\DagBundle\Tests\IntegrationTestCase;
use MLB\DagBundle\Entity\DagEdge;
use MLB\DagBundle\Entity\DagNode;
use MLB\DagBundle\Entity\DagEdgeRepository;
use MLB\DagBundle\Entity\DagNodeRepository;



class DagConnectFunctionalTest extends IntegrationTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;


    public function testDbInit()
    {
	    $this->em = static::getEntityManager();

        $dn = new LoadDagNodes();
        $dn->load($this->em);

        $de = new LoadDagEdges();
        $de->load($this->em);
    }

    /*
     * @depends testDbInit
     */
    public function testInitialCreation()
    {
        $this->em = static::getEntityManager();
        // Count only direct edges
        $edgeRepo = $this->em->getRepository('MLB\DagBundle\Entity\DagEdge');
        $direct = $edgeRepo->findAllDirectEdges();
        $this->assertCount(12, $direct);
        
        // Test for test nodes to exist
        $nodeRepo = $this->em->getRepository('MLB\DagBundle\Entity\DagNode');
        $node0 = $nodeRepo->findOneByName('Node 0');
        $this->assertNotNull($node0);
        $node1 = $nodeRepo->findOneByName('Node 1');
        $this->assertNotNull($node1);
        $node2 = $nodeRepo->findOneByName('Node 2');
        $this->assertNotNull($node2);
        $node3 = $nodeRepo->findOneByName('Node 3');
        $this->assertNotNull($node3);
        $node4 = $nodeRepo->findOneByName('Node 4');
        $this->assertNotNull($node4);
        $node5 = $nodeRepo->findOneByName('Node 5');
        $this->assertNotNull($node5);
        $node6 = $nodeRepo->findOneByName('Node 6');
        $this->assertNotNull($node6);
        $node7 = $nodeRepo->findOneByName('Node 7');
        $this->assertNotNull($node7);
        $node8 = $nodeRepo->findOneByName('Node 8');
        $this->assertNotNull($node8);
        $node9 = $nodeRepo->findOneByName('Node 9');
        $this->assertNotNull($node9);
        
        // Count all the edges
        $dql =  'SELECT count(e)'.
                '  FROM MLB\DagBundle\Entity\DagEdge e';
        $query = $this->em->createQuery($dql);

        $count = $query->getOneOrNullResult();
        $this->assertEquals(30, $count);
        
        // Test edges from node 0 to node 1
        $edges01 = $edgeRepo->findEdges($node0, $node1);
        $this->assertCount(1, $edges01);
        $this->assertEquals($edges01[0]->getHops(), 0);

        // Test edges from node 0 to node 2
        $edges02 = $edgeRepo->findEdges($node0, $node2);
        $this->assertCount(2, $edges02);
        $this->assertEquals($edges02[0]->getHops(), 0);
        $this->assertEquals($edges02[1]->getHops(), 1);

        // Test edges from node 0 to node 3
        $edges03 = $edgeRepo->findEdges($node0, $node3);
        $this->assertCount(3, $edges03);
        $this->assertEquals($edges03[0]->getHops(), 0);
        $this->assertEquals($edges03[1]->getHops(), 1);
        $this->assertEquals($edges03[2]->getHops(), 2);

        // Test edges from node 0 to node 4
        $edges04 = $edgeRepo->findEdges($node0, $node4);
        $this->assertCount(3, $edges04);
        $this->assertEquals($edges04[0]->getHops(), 1);
        $this->assertEquals($edges04[1]->getHops(), 2);
        $this->assertEquals($edges04[2]->getHops(), 3);

        // Test edges from node 1 to node 2
        $edges12 = $edgeRepo->findEdges($node1, $node2);
        $this->assertCount(1, $edges12);
        $this->assertEquals($edges12[0]->getHops(), 0);

        // Count edges from node 1 to node 3
        $edges13 = $edgeRepo->findEdges($node1, $node3);
        $this->assertCount(1, $edges13);
        $this->assertEquals($edges13[0]->getHops(), 1);

        // Test edges from node 1 to node 4
        $edges14 = $edgeRepo->findEdges($node1, $node4);
        $this->assertCount(1, $edges14);
        $this->assertEquals($edges14[0]->getHops(), 2);

        // Test edges from node 2 to node 3
        $edges23 = $edgeRepo->findEdges($node2, $node3);
        $this->assertCount(1, $edges23);
        $this->assertEquals($edges23[0]->getHops(), 0);

        // Test edges from node 2 to node 4
        $edges24 = $edgeRepo->findEdges($node2, $node4);
        $this->assertCount(1, $edges24);
        $this->assertEquals($edges24[0]->getHops(), 1);

        // Test edges from node 3 to node 4
        $edges34 = $edgeRepo->findEdges($node3, $node4);
        $this->assertCount(1, $edges34);
        $this->assertEquals($edges34[0]->getHops(), 0);

        // Test edges from node 5 to node 6
        $edges56 = $edgeRepo->findEdges($node5, $node6);
        $this->assertCount(1, $edges56);
        $this->assertEquals($edges56[0]->getHops(), 0);

        // Test edges from node 5 to node 7
        $edges57 = $edgeRepo->findEdges($node5, $node7);
        $this->assertCount(2, $edges57);
        $this->assertEquals($edges57[0]->getHops(), 0);
        $this->assertEquals($edges57[1]->getHops(), 1);

        // Test edges from node 5 to node 8
        $edges58 = $edgeRepo->findEdges($node5, $node8);
        $this->assertCount(3, $edges58);
        $this->assertEquals($edges58[0]->getHops(), 0);
        $this->assertEquals($edges58[1]->getHops(), 1);
        $this->assertEquals($edges58[2]->getHops(), 2);

        // Test edges from node 5 to node 9
        $edges59 = $edgeRepo->findEdges($node5, $node9);
        $this->assertCount(3, $edges59);
        $this->assertEquals($edges59[0]->getHops(), 1);
        $this->assertEquals($edges59[1]->getHops(), 2);
        $this->assertEquals($edges59[2]->getHops(), 3);

        // Test edges from node 6 to node 7
        $edges67 = $edgeRepo->findEdges($node6, $node7);
        $this->assertCount(1, $edges67);
        $this->assertEquals($edges67[0]->getHops(), 0);

        // Count edges from node 6 to node 8
        $edges68 = $edgeRepo->findEdges($node6, $node8);
        $this->assertCount(1, $edges68);
        $this->assertEquals($edges68[0]->getHops(), 1);

        // Test edges from node 6 to node 9
        $edges69 = $edgeRepo->findEdges($node6, $node9);
        $this->assertCount(1, $edges69);
        $this->assertEquals($edges69[0]->getHops(), 2);

        // Test edges from node 7 to node 8
        $edges78 = $edgeRepo->findEdges($node7, $node8);
        $this->assertCount(1, $edges78);
        $this->assertEquals($edges78[0]->getHops(), 0);

        // Test edges from node 7 to node 9
        $edges79 = $edgeRepo->findEdges($node7, $node9);
        $this->assertCount(1, $edges79);
        $this->assertEquals($edges79[0]->getHops(), 1);

        // Test edges from node 8 to node 9
        $edges89 = $edgeRepo->findEdges($node8, $node9);
        $this->assertCount(1, $edges89);
        $this->assertEquals($edges89[0]->getHops(), 0);
    }

    /*
     * @depends testInitialCreation
     */
    public function testConnection()
    {

        $this->em = static::getEntityManager();
        $nodeRepo = $this->em->getRepository('MLB\DagBundle\Entity\DagNode');
        $node4 = $nodeRepo->findOneByName('Node 4');
        $node5 = $nodeRepo->findOneByName('Node 5');
        
        $edgeRepo = $this->em->getRepository('MLB\DagBundle\Entity\DagEdge');
        $edgeRepo->createEdge($node4, $node5);
        $direct = $edgeRepo->findAllDirectEdges();

        $this->assertCount(13, $direct);

        $edgeRepo->deleteEdgeByEnds($node4, $node5);
        $direct = $edgeRepo->findAllDirectEdges();
        
        $this->assertCount(12, $direct);
    }
}
