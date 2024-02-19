<?php
function getDbConnection()
{
    return pg_connect("host=localhost port=5432 dbname=finalexam user=postgres password=Matt2610");
}
