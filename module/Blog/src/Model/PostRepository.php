<?php

namespace Blog\Model;

class PostRepository implements PostRepositoryInterface
{
    private $data = [
        1 => [
            'id'    => 1,
            'title' => 'Text1',
            'text'  => 'Text1',
        ],
        2 => [
            'id'    => 2,
            'title' => 'Text2',
            'text'  => 'Text2',
        ],
        3 => [
            'id'    => 3,
            'title' => 'Text3',
            'text'  => 'Text3',
        ],
    ];
    
    public function findAllPosts()
    {
        return array_map(function($post) {
            return new Post(
                $post['id'],
                $post['title'],
                $post['text']
            );
        }, $this->data);
    }
    
    public function findPost($id)
    {
        if (!isset($this->data[$id])) {
            throw new DomainException(sprintf('Post id "%s" nie został znaleziony', $id));
        }

        return new Post(
            $this->data[$id]['id'],
            $this->data[$id]['title'],
            $this->data[$id]['text']
        );
    }
    
}