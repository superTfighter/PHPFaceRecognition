<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


$app->group('/admin', function () use ($container) {

    $this->get('',            '@Admin\AdminAction:index')->setName('admin.index');

    $this->get('/users',      '@Admin\AdminAction:usersPage')->setName('admin.users');
    $this->get('/database',   '@Admin\AdminAction:databasePage')->setName('admin.database');


    $this->group('/json', function () use ($container) {

        $this->get('/users',      '@Admin\AdminAction:usersJson')->setName('admin.users.json');
        $this->get('/tables',     '@Admin\AdminAction:allTablesJson')->setName('admin.tables.json'); 


    });

    $this->group('/ajax', function () use ($container) {

        $this->delete('/user/{id}',            '@Admin\AdminAction:deleteUser')->setName('admin.users.delete.ajax');
        
        $this->delete('/database/{name}',      '@Admin\AdminAction:truncateTable')->setName('admin.database.delete.ajax');


    });

});

