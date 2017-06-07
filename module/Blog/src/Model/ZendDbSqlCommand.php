<?php
namespace Blog\Model;

use RuntimeException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;

class ZendDbSqlCommand implements PostCommandInterface
{
    private $db;
    
    public function __construct(AdapterInterface $db)
    {
        $this->db = $db;
    }

    public function insertPost(Post $post)
    {
        $insert = new Insert('article');
        $insert->values([
            'title' => $post->getTitle(),
            'text' => $post->getText(),
            'aDate' => $post->getADate(),
            'author' => $post->getAuthor(),
        ]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if (! $result instanceof ResultInterface) {
            throw new RuntimeException(
                'Błąd bazy podczas dodawania artykułu.'
            );
        }

        $id = $result->getGeneratedValue();

        return new Post(
            $post->getTitle(),
            $post->getText(),
            $post->getADate(),
            $post->getAuthor(),
            $result->getGeneratedValue()
        );
    }

    public function updatePost(Post $post)
    {
        if (! $post->getId()) {
            throw new RuntimeException('Nie można zaktualizować artukułu; brak identyfikatora.');
        }

        $update = new Update('article');
        $update->set([
            'title' => $post->getTitle(),
            'text' => $post->getText(),
            'aDate' => $post->getADate(),
            'author' => $post->getAuthor(),
        ]);
        $update->where(['id = ?' => $post->getId()]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        if (! $result instanceof ResultInterface) {
            throw new RuntimeException(
                'Błąd bazy danych podczas aktualizacji artykułu.'
            );
        }

        return $post;
    }

    public function deletePost(Post $post)
    {
        if (! $post->getId()) {
        throw new RuntimeException('Brak indetyfikatora.');
    }

    $delete = new Delete('article');
    $delete->where(['id = ?' => $post->getId()]);

    $sql = new Sql($this->db);
    $statement = $sql->prepareStatementForSqlObject($delete);
    $result = $statement->execute();

    if (! $result instanceof ResultInterface) {
        return false;
    }

    return true;
    }
}