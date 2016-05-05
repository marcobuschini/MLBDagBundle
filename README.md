[![Stories in Ready](https://badge.waffle.io/marcobuschini/MLBDagBundle.png?label=ready&title=Ready)](https://waffle.io/marcobuschini/MLBDagBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/74c5de39-97be-43bb-a7ca-983629edd476/mini.png)](https://insight.sensiolabs.com/projects/74c5de39-97be-43bb-a7ca-983629edd476)
[![Build Status](https://travis-ci.org/marcobuschini/MLBDagBundle.svg?branch=master)](https://travis-ci.org/marcobuschini/MLBDagBundle)
[![Coverage Status](https://coveralls.io/repos/github/marcobuschini/MLBDagBundle/badge.svg?branch=master)](https://coveralls.io/github/marcobuschini/MLBDagBundle?branch=master)

# marcobuschini/MLBDagBundle

When managing complex relationship between entities belonging to the real world
we often see that they cannot fit simple data models, such as lists, maps, and
even trees.

This Symony2 bundle implements a Doctrine data model that allows an application
to manage Directed Acyclic Graphs by using both an adjacency list, and a full
transitive closure for indirect edges.

A DAG is a set of nodes connected by a set of oriented edges so that no closed
loop (cycle) can be created in the data structure. This structure is best
handled with an adjacency list, that is a list of edges connecting pairs of
nodes (edge E connects node A to node B, but not the opposite). To prevent
large amounts of queries to find if node B is reachable from node A a full
transitive closure is implemented, that is a list of indirect edges is
managed by the bundle. So that if node A connects to node B that connects to
node C, an indirect edge from node A to node C is managed by the bundle's
logic.

It is important to note that the data structure MUST NOT be modified outside
of this bundle as the logic for preventing cycles, and for creating indirect
edges IS NOT handled by the database, but by the bundle itself.
