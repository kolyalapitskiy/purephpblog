<?php
//$root = __DIR__;
//$db = $root . '/config.php';
//class Database
//{
//    private static $connection;
//    public function __construct($config) {
//        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'];
//        $this->connection = new PDO($dsn, 'root', '', [
//            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//        ]);
//    }
//
//    public function query() {
//        $stmt = $this->connection->prepare("SELECT * FROM blogs");
//        $stmt->execute();
//        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
//    }
//}


class Database {
    private static $connection;
    public function __construct($config) {
        $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'];
        $this->connection = new PDO($dsn, 'root', '', [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public function query() {
        $stmt = $this->connection->prepare("SELECT * FROM blogs ORDER by id");
        $stmt->execute();
        $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        forEach($blogs as &$blog) {
            $stmt = $this->connection->prepare('SELECT * FROM comments WHERE blog_id = ? ORDER by id');
            $stmt ->execute([$blog['id']]);
            $blog['comments'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $blogs;
    }
}