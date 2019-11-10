<?php

include_once("database.php");

try
{
    $conn->query('CREATE DATABASE IF NOT EXISTS db_camagru');
    $conn->query('USE db_camagru');

    $conn->query(
        'CREATE TABLE IF NOT EXISTS `users` (
        username varchar(12) NOT NULL,
        email varchar(64) NOT NULL,
        password varchar(60) NOT NULL,
        joined datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        notice int(1) NOT NULL DEFAULT 1,
        propic mediumtext,
        reset_key varchar(60),
        PRIMARY KEY (username),
        UNIQUE KEY (username),
        UNIQUE KEY (reset_key)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8');

    $conn->query(
        'CREATE TABLE IF NOT EXISTS `unconfirmed_users` (
        username varchar(12) NOT NULL,
        email varchar(64) NOT NULL,
        password varchar(60) NOT NULL,
        confirm_key varchar(60) NOT NULL,
        PRIMARY KEY (username),
        UNIQUE KEY (username),
        UNIQUE KEY (confirm_key)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8');

    $conn->query(
        'CREATE TABLE IF NOT EXISTS `imgs` (
        img_id int(20) AUTO_INCREMENT NOT NULL,
        username varchar(12) NOT NULL,
        img_base64 mediumtext NOT NULL,
        upload_time datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (img_id),
        UNIQUE KEY (img_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8');

    $conn->query(
        'CREATE TABLE IF NOT EXISTS `comments` (
        img_id int(20) NOT NULL,
        username varchar(12) NOT NULL,
        comment text,
        `like` int(1) NOT NULL DEFAULT 0,
        comment_time datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8');

    echo "Success";
}
catch (PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

?>