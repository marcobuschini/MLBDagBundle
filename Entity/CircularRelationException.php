<?php
namespace Mlb\DagBundle\Entity;

use Mlb\DagBundle\Entity;

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
     * The code to load the the detected loop is as follows:
     * 
     * ```php
     * $edges = $edgeRepo->findEdges($end, $start);
     * foreach($edges as $edge) {
     *     $edge->getId();
     *     $edge->getStartNode(); // Should always be $end
     *     $edge->getEndNode();   // Should always be $start
     *     $edge->getHops();
     * }
     * ```
     *
     * @param DagEdgeRepository $edgeRepo The edge repository to be used when analyzing the loop
     * @param DagNode $start The node the craated edge would have started at
     * @param DagNode $end The node the craated edge would have ended at
     */
    public function __construct(DagNode $start, DagNode $end) {
        if($start->getId() === $end->getId()) {
            parent::__construct('You cannot connect node '.$start->getId().' to itself, this will create a loop!');
        } else {
            $message = 'You cannot connect node '.$start->getId().' to node '.$end->getId().', this will create a loop.'.PHP_EOL;
            parent::__construct($message);
        }
    }   
}
