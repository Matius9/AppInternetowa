<?php

namespace Blog\Model;

use InvalidArgumentException;
use RuntimeException;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ZendDbSqlRepository implements PostRepositoryInterface
{
    private $db;
    private $hydrator;
    private $postPrototype;
    
    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator,
        Post $postPrototype
    ) {
        $this->db            = $db;
        $this->hydrator      = $hydrator;
        $this->postPrototype = $postPrototype;
    }
    
    public function findAllPosts($paginated = false)
    {
        if($paginated) {
            return $this->findPaginatedPosts();
        }
        
        $sql    = new Sql($this->db);
        $select = $sql->select('article');
        $select->order('id DESC');
        
        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        
        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            return [];
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
        $resultSet->initialize($result);
        return $resultSet;
    }
    
    public function findPaginatedPosts()
    {
        
        $sql    = new Sql($this->db);
        $select = new Select();
        $select
            ->from('article')
            ->order('id DESC');
        
        //$stmt   = $sql->prepareStatementForSqlObject($select);
        //$result = $stmt->execute();
        
        //if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
        //    return [];
        //}

        $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
        
        
        $adapter = new DbSelect($select, $sql, $resultSet);
        $paginator = new Paginator($adapter);
        
        return $paginator;
    }

    public function findPost($id)
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('article');
        $select->where(['id = ?' => $id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Błąd pobierania danych o poście id "%s".',
                $id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
        $resultSet->initialize($result);
        $post = $resultSet->current();

        if (! $post) {
            throw new InvalidArgumentException(sprintf(
                'Post o id "%s" nie został znaleziony.',
                $id
            ));
        }

        return $post;
    }
}