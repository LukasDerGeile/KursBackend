<?php





/**

 * Utility class for database connectivity

 */

class DB {



    private string $host;

    private string $username;

    private string $password;

    private string $database;

    private string $charset;

    private string $dsn;

    private array $options;

    private $connection;



    /**

     * Constructor

     *

     * @param string $host

     * @param string $username

     * @param string $password

     * @param string $database

     * @param string $charset utf8

     */

    public function __construct(string $host, string $username, string $password, string $database, string $charset = 'utf8') {

        $this->host = $host;

        $this->username = $username;

        $this->password = $password;

        $this->database = $database;

        $this->charset = $charset;



        // Build DSN (Data Source Name)

        $this->dsn = "mysql:host=$this->host;dbname=$this->database;charset=$this->charset";



        // PDO options

        $this->options = [

            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,

            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

            PDO::ATTR_EMULATE_PREPARES   => false,

        ];

    }



    // Function to establish a database connection



    /**

     * @throws Exception

     * Create a new database connection

     */

    public function connect(): PDO

    {

        try {

            $this->connection = new PDO($this->dsn, $this->username, $this->password, $this->options);

            return $this->connection;

        } catch (PDOException $e) {

            throw new Exception("Connection failed: " . $e->getMessage());

        }

    }





    /**

     * @return void

     * Closes the database connection

     */

    // Function to close the database connection

    public function close(): void

    {

        $this->connection = null;

    }

}