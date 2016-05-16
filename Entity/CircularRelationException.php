<?php
namespace MLB\DagBundle\Entity;

use MLB\DagBundle\Entity;

/**
 * This exception is thrown when a loop is detected in the graph.
 * 
 * Every time an edge is created between two nodes this bundle checks if the
 * edge will create a circular relation. As circular relations are forbidden in
 * directed acyclic graphs this exception is thrown to alert of that event.
 * 
 * This exception should be bubbled up to the enf user so that the end user can
 * manually handle the issue.
 */
class CircularRelationException extends \Exception {
 
    /**
     * Thrown in case someone tries to create a circular relation.
     * 
     * A circular relation is a set of edges that connect a node back to itself,
     * such as node A that connects to node B, node B that connects to node C,
     * that connects back to node A.
     * 
     * This library takes care that no circular relation can be created with it,
     * and throws this exception if a connection violates this rule.
     * 
     * @param type $message The message to be reported
     * @param type $code The code to be reported
     * @param \Exception $previous The exception that preceds this one in the chain
     */
    public function __construct(DagNode $start, DagNode $end) {
        if($start->getId() === $end->getId()) {
            parent::__construct('You cannot connect node '.$start->getId().' to itself, this will create a loop!');
        } else {
            $message = 'You cannot connect node '.$start->getId().' to node '.$end->getId().', this will create a loop!';
            parent::__construct($message);
        }
    }   
}

