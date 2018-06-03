<?php
/* Function that executes a sql query and returns the result */
function ReturnQueryResult($query, $arguments, $dbObject){
  $stmnt = $dbObject->prepare($query);
  $stmnt->execute($arguments);
  return $stmnt->fetchAll(PDO::FETCH_ASSOC);
}

/* Function that executes a sql query and doesn't return the result */
function ExecuteQuery($query, $arguments, $dbObject){
  $stmnt = $dbObject->prepare($query);
  $stmnt->execute($arguments);
}
