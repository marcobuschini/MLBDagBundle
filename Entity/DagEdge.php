<?php

namespace MLB\DagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This entity represents a connection between nodes in the graph.
 *
 * @ORM\Table(name="dag_edge")
 * @ORM\Entity(repositoryClass="MLB\DagBundle\Entity\DagEdgeRepository")
 */
class DagEdge
{
    /**
     * @var id The ID of the edge.
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var incoming_edge The incoming edge responsible for the creation of this edge.
     * 
     * @ORM\ManyToOne(targetEntity="DagEdge")
     * @ORM\JoinColumn(name="incoming_edge_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $incoming_edge;

    /**
     * @var direct_edge The direct edge responsible for the creation of this edge.
     * 
     * @ORM\ManyToOne(targetEntity="DagEdge")
     * @ORM\JoinColumn(name="direct_edge_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $direct_edge;

    /**
     * @var outgoing_edge The outgoing edge responsible for the creation of this edge.
     * 
     * @ORM\ManyToOne(targetEntity="DagEdge")
     * @ORM\JoinColumn(name="outgoing_edge_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $outgoing_edge;

    /**
     * @var start_node The node this edge starts from.
     * 
     * @ORM\ManyToOne(targetEntity="DagNode")
     * @ORM\JoinColumn(name="start_node_id", referencedColumnName="id", onDelete="RESTRICT")
     **/
    private $start_node;

    /**
     * @var end_node The node this edge end to.
     * 
     * @ORM\ManyToOne(targetEntity="DagNode")
     * @ORM\JoinColumn(name="end_node_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $end_node;
    
    /**
     * The number of hops (i.e. direct edges) this edge skips.
     * @ORM\Column(type="integer")
     */
    private $hops;
    
    /**
     * Gets the ID of the edge
     *
     * @return id 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the number of hops this edge skips.
     *
     * @param integer $hops
     * @return DagEdge
     */
    public function setHops($hops)
    {
        $this->hops = $hops;

        return $this;
    }

    /**
     * Gets the number of hops this edge skips.
     *
     * @return integer 
     */
    public function getHops()
    {
        return $this->hops;
    }

    /**
     * Sets the incoming edge responsible for the creation of this edge.
     *
     * @param MLB\DagBundle\Entity\DagEdge $incomingEdge
     * @return DagEdge
     */
    public function setIncomingEdge(DagEdge $incomingEdge = null)
    {
        $this->incoming_edge = $incomingEdge;

        return $this;
    }

    /**
     * Gets the incoming edge responsible for the creation of this edge.
     *
     * @return MLB\DagBundle\Entity\DagEdge
     */
    public function getIncomingEdge()
    {
        return $this->incoming_edge;
    }

    /**
     * Sets the direct edge responsible for the creation of this edge.
     *
     * @param MLB\DagBundle\Entity\DagEdge $directEdge
     * @return DagEdge
     */
    public function setDirectEdge(DagEdge $directEdge = null)
    {
        $this->direct_edge = $directEdge;

        return $this;
    }

    /**
     * Gets the direct edge responsible for the creation of this edge.
     *
     * @return MLB\DagBundle\Entity\DagEdge
     */
    public function getDirectEdge()
    {
        return $this->direct_edge;
    }

    /**
     * Sets the outgoing edge responsible for the creation of this edge.
     *
     * @param MLB\DagBundle\Entity\DagEdge $outgoingEdge
     * @return DagEdge
     */
    public function setOutgoingEdge(DagEdge $outgoingEdge = null)
    {
        $this->outgoing_edge = $outgoingEdge;

        return $this;
    }

    /**
     * Gets the outgoing edge responsible for the creation of this edge.
     *
     * @return MLB\DagBundle\Entity\DagEdge
     */
    public function getOutgoingEdge()
    {
        return $this->outgoing_edge;
    }

    /**
     * Sets the start node responsible for the creation of this edge.
     *
     * @param MLB\DagBundle\Entity\DagNode $startNode
     * @return DagEdge
     */
    public function setStartNode(DagNode $startNode = null)
    {
        $this->start_node = $startNode;

        return $this;
    }

    /**
     * Gets the start node responsible for the creation of this edge.
     *
     * @return MLB\DagBundle\Entity\DagNode
     */
    public function getStartNode()
    {
        return $this->start_node;
    }

    /**
     * Sets the edn node responsible for the creation of this edge.
     *
     * @param MLB\DagBundle\Entity\DagNode $endNode
     * @return DagEdge
     */
    public function setEndNode(DagNode $endNode = null)
    {
        $this->end_node = $endNode;

        return $this;
    }

    /**
     * Gets the end node responsible for the creation of this edge.
     *
     * @return MLB\DagBundle\Entity\DagNode
     */
    public function getEndNode()
    {
        return $this->end_node;
    }
}
