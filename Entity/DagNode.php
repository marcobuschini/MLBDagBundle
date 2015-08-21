<?php

namespace MLB\DagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DagNode
 *
 * @ORM\Table(name="dag_node")
 * @ORM\Entity(repositoryClass="MLBDagBundle\Entity\DagNodeRepository")
 */
class DagNode
{
    /**
     * @var guid
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var name
     * @ORM\Column(name="name", type="string", length=80, nullable=false)
     */
     private $name;

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
     * Set name
     *
     * @param string $name
     * @return DagNode
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function __construct($name)
    {
        $this->setName($name);
    }
}
