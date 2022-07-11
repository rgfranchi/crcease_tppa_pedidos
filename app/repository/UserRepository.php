<?php
namespace TPPA\APP\repository;
use TPPA\CORE\repository\BasicRepository;

class userRepository extends BasicRepository {
    function __construct() 
    {
        parent::__construct("User");
    }
}