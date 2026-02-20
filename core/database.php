<?php
// Класс подключения к базе данных, класс используется потому
class Database {
    private $connection; //

    public function __construct($config) { // __construct это функция которая вызовет сама себя при запуске, из-за этого тут нет имени.
        $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'];
        $this->connection = new PDO($dsn, 'root', '', [ // тут мы обращаемся к $this->connection Для того чтобы перезаписать состояние этой переменной, а new PDO, это класс из-за этого new, а его название PDO.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public function query() { // функция sql запрос
        $stmt = $this->connection->prepare("SELECT * FROM posts ORDER By id");
        $stmt->execute();
        $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        forEach($blogs as &$blog) {
            $stmt = $this->connection->prepare("SELECT * FROM comments WHERE blog_id = ? ORDER By id");
            $stmt->execute([$blog['id']]);
            $blog['comments'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $blogs;
    }
}