<?php

namespace MLB\DagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DagEdge
 *
 * @ORM\Table(name="dag_edge")
 * @ORM\Entity(repositoryClass="MLB\DagBundle\Entity\DagEdgeRepository")
 */
class DagEdge
{
    /**
     * @var id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="DagEdge")
     * @ORM\JoinColumn(name="incoming_edge_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $incoming_edge;

    /**
     * @ORM\ManyToOne(targetEntity="DagEdge")
     * @ORM\JoinColumn(name="direct_edge_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $direct_edge;

    /**
     * @ORM\ManyToOne(targetEntity="DagEdge")
     * @ORM\JoinColumn(name="outgoing_edge_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $outgoing_edge;

    /**
     * @ORM\ManyToOne(targetEntity="DagNode")
     * @ORM\JoinColumn(name="start_node_id", referencedColumnName="id", onDelete="RESTRICT")
     **/
    private $start_node;

    /**
     * @ORM\ManyToOne(targetEntity="DagNode")
     * @ORM\JoinColumn(name="end_node_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $end_node;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $hops;
    
    /**
     * Get id
     *
     * @return guid 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hops
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
     * Get hops
     *
     * @return integer 
     */
    public function getHops()
    {
        return $this->hops;
    }

    /**
     * Set incoming_edge
     *
     * @param MLB\DagBundle\Entity\DagEdge $incomingEdge
     * @return DagEdge
     */
    public function setIncomingEdge(MLB\DagBundle\Entity\DagEdge $incomingEdge = null)
    {
        $this->incoming_edge = $incomingEdge;

        return $this;
    }

    /**
     * Get incoming_edge
     *
     * @return MLB\DagBundle\Entity\DagEdge
     */
    public function getIncomingEdge()
    {
        return $this->incoming_edge;
    }

    /**
     * Set direct_edge
     *
     * @param MLB\DagBundle\Entity\DagEdge $directEdge
     * @return DagEdge
     */
    public function setDirectEdge(MLB\DagBundle\Entity\DagEdge $directEdge = null)
    {
        $this->direct_edge = $directEdge;

        return $this;
    }

    /**
     * Get direct_edge
     *
     * @return MLB\DagBundle\Entity\DagEdge
     */
    public function getDirectEdge()
    {
        return $this->direct_edge;
    }

    /**
     * Set outgoing_edge
     *
     * @param MLB\DagBundle\Entity\DagEdge $outgoingEdge
     * @return DagEdge
     */
    public function setOutgoingEdge(MLB\DagBundle\Entity\DagEdge $outgoingEdge = null)
    {
        $this->outgoing_edge = $outgoingEdge;

        return $this;
    }

    /**
     * Get outgoing_edge
     *
     * @return MLB\DagBundle\Entity\DagEdge
     */
    public function getOutgoingEdge()
    {
        return $this->outgoing_edge;
    }

    /**
     * Set start_node
     *
     * @param MLB\DagBundle\Entity\DagNode $startNode
     * @return DagEdge
     */
    public function setStartNode(MLB\DagBundle\Entity\DagNode $startNode = null)
    {
        $this->start_node = $startNode;

        return $this;
    }

    /**
     * Get start_node
     *
     * @return MLB\DagBundle\Entity\DagNode
     */
    public function getStartNode()
    {
        return $this->start_node;
    }

    /**
     * Set end_node
     *
     * @param MLB\DagBundle\Entity\DagNode $endNode
     * @return DagEdge
     */
    public function setEndNode(MLB\DagBundle\Entity\DagNode $endNode = null)
    {
        $this->end_node = $endNode;

        return $this;
    }

    /**
     * Get end_node
     *
     * @return MLB\DagBundle\Entity\DagNode
     */
    public function getEndNode()
    {
        return $this->end_node;
    }
}
