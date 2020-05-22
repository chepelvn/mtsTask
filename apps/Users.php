<?php

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 21.05.2020
 * Time: 22:21
 */
class Users extends UsersFactory
{
    public function getItems(){
        $q = parent::DB()->prepare("SELECT * FROM users");
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $items = $q->fetchAll();
        jsonDisplay($items);
    }

    public function getById($id = null){
        $q = parent::DB()->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $q->bindParam(':id', $id);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $items = $q->fetchAll();
        jsonDisplay($items);
    }

    public function action(){
        render('users');
    }
}