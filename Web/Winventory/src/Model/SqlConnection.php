<?php
class SqlConnection {


    private static $connection;

    /**
     * SqliteConnection constructor.
     */
    public function __construct() {
        $dsn = 'mysql:host=localhost;port=3307;dbname=winventory;';
        $user = 'worty';
        $password = 'DmYmF4HThEk2jXFIAbq8';
        try
        {
            self::$connection = new PDO($dsn, $user, $password);
        }
        catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    /**
     * Retourne la connexion de la base de données
     * @return Connection la connection à la base de données
     */
    public final static function getConnection() {
        if(!isset(self::$connection)) {
            new SqlConnection();
        }
        return self::$connection;
    }

}

?>
