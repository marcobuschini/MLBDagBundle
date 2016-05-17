<?php

namespace Mlb\DagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This entity represents a node in the graph.
 *
 * @ORM\Table(name="dag_node")
 * @ORM\Entity(repositoryClass="MLB\DagBundle\Entity\DagNodeRepository")
 */
class DagNode
{
    /**
     * @var id The ID of the node.
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var name The name of the node.
     * 
     * @ORM\Column(name="name", type="string", length=80, nullable=false)
     */
     private $name;

    /**
     * Get the ID of the node.
     *
     * @return guid 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Sets the name of the node.
     *
     * @param string $name The name of the node.
     * @return DagNode Returns the node itself for method chaining.
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the name of the node.
     *
     * @return string The name of the node.
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Creates a node with the given name.
     * 
     * @param type $name The name of the node.
     */
    public function __construct($name)
    {
        $this->setName($name);
    }
}
