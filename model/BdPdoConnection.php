<?php
class BdPdoConnection {

    // Singleton instance
    private static $lInstanceSingleton = null;

    // PDO instance
    private static $objPDO;

    // Database connection parameters
    private static $host = "mysql-meganesusini.alwaysdata.net";
    private static $dbname = "meganesusini_myfirstgame";
    private static $user = "300808";
    private static $password = "alwaysdata40";

    // Private constructor to prevent direct class instantiation
    private function __construct() {
        try {
            // Connection to the database
            self::$objPDO = new PDO("mysql:host=".self::$host.";dbname=".self::$dbname, self::$user, self::$password);
            self::$objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$objPDO->query("SET CHARACTER SET utf8");
        } catch (PDOException $erreur) {
            echo "Erreur de connexion à la base de données " . $erreur->getMessage();
        }
    }

    // Method to retrieve the singleton instance of the connection
    public static function getLInstanceSingleton() {
        if (self::$lInstanceSingleton == null) {
            self::$lInstanceSingleton = new BdPdoConnection();
        }
        return self::$lInstanceSingleton;
    }

    // Method to retrieve the PDO instance of the connection
    public static function getConnection() {
        if (self::$lInstanceSingleton == null) {
            self::$lInstanceSingleton = new BdPdoConnection();
        }
        return self::$objPDO;
    }

}

?>