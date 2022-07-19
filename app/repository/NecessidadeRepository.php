<?php
namespace TPPA\APP\repository;
use TPPA\CORE\repository\BasicRepository;

class NecessidadeRepository extends BasicRepository {
    function __construct() 
    {
        parent::__construct("Necessidade");
    }
}