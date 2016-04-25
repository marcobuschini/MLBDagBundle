<?php
namespace MLB\DagBundle\Entity;

/**
 * This exception is thrown when a non exising edge is being deleted.
 * 
 * This could happen when the caller wants to disconnect nodes that are not
 * connected, or when two distinct callers delete the same edge at the same
 * time.
 * 
 * This exception should be bubbled up to the enf user so that the end user can
 * manually handle the issue.
 */
class EdgeDoesNotExistException extends \Exception {

    /**
     * Thrown in case someone tries to delete a non exising, or a non-direct edge.
     * 
     * Indirect edges cannot be deleted directly because their existence is
     * tied to the existence of the chain of direct edges that created them.
     * 
     * @param type $message The message to be reported
     * @param type $code The code to be reported
     * @param \Exception $previous The exception that preceds this one in the chain
     */
    public function __construct($message, $code = 0, \Exception $previous = null) {
        // some code
    
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
