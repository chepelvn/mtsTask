<?php

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 21.05.2020
 * Time: 22:21
 */
class Table extends TableFactory
{
    public function action(){

        $pdo = parent::DB();
        $query = $pdo->prepare('SELECT * FROM table');
        $query->bindValue(':ddd', 'd');
        $query->execute();
        $all = $query->fetchAll();

        render('index', [
            'items' => []
        ]);
    }
}