<?php

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private $connection;
    private $testUserId;
    private $testConsoleId;
    private $testGenreId;
    private $testVideogameId;

    protected function setUp(): void
    {
        // Crear conexión de prueba
        $connectionData = [
            "host" => $_ENV['DB_HOST'] ?? 'db',
            "dbUser" => $_ENV['DB_USER'] ?? 'root',
            "dbPassword" => $_ENV['DB_PASSWORD'] ?? 'root',
            "db" => $_ENV['DB_NAME'] ?? 'inventory_new'
        ];
        
        $this->connection = createConnection($connectionData);
        $this->assertNotNull($this->connection, 'Database connection should not be null');
    }

    protected function tearDown(): void
    {
        // Limpiar datos de prueba
        if ($this->connection) {
            if ($this->testVideogameId) {
                deleteVideogame($this->connection, $this->testVideogameId, $this->testUserId);
            }
            if ($this->testConsoleId) {
                deleteConsole($this->connection, $this->testConsoleId, $this->testUserId);
            }
            if ($this->testGenreId) {
                deleteGenre($this->connection, $this->testGenreId);
            }
            if ($this->testUserId) {
                $this->connection->query("DELETE FROM users WHERE id = {$this->testUserId}");
            }
        }
    }

    public function testCreateConnection()
    {
        $this->assertInstanceOf(mysqli::class, $this->connection);
        $this->assertFalse($this->connection->connect_error);
    }

    public function testUserOperations()
    {
        // Test user creation
        $username = 'testuser_' . time();
        $password = 'testpassword';
        $hash = encryptPassword($password);
        $image = 'test.jpg';
        
        setUser($this->connection, $username, $hash, $image);
        
        // Test get user ID
        $userId = getId($this->connection, $username);
        $this->assertNotNull($userId);
        $this->testUserId = $userId;
        
        // Test get user hash
        $userHash = getHash($this->connection, $username);
        $this->assertEquals($hash, $userHash);
        
        // Test get user profile
        $profile = getProfile($this->connection, $userId);
        $this->assertEquals($username, $profile['username']);
        $this->assertEquals($image, $profile['image']);
        
        // Test check if user exists
        $this->assertEquals(EXISTSERROR, checkIfUserExists($this->connection, $username));
        $this->assertEquals(NOERROR, checkIfUserExists($this->connection, 'nonexistentuser'));
    }

    public function testGenreOperations()
    {
        // Test genre creation
        $genre = 'TestGenre_' . time();
        $image = 'genre.jpg';
        
        setGenre($this->connection, $genre, $image);
        
        // Test get genre by ID (we need to find the ID first)
        $genres = getGenres($this->connection);
        $testGenre = null;
        foreach ($genres as $g) {
            if ($g['genre'] === $genre) {
                $testGenre = $g;
                break;
            }
        }
        
        $this->assertNotNull($testGenre);
        $this->testGenreId = $testGenre['id'];
        
        // Test get genre by ID
        $genreData = getGenreById($this->connection, $this->testGenreId);
        $this->assertEquals($genre, $genreData['genre']);
        
        // Test check if genre exists
        $this->assertEquals(EXISTSERROR, checkIfGenreExists($this->connection, $genre));
        $this->assertEquals(NOERROR, checkIfGenreExists($this->connection, 'nonexistentgenre'));
    }

    public function testConsoleOperations()
    {
        // First create a test user
        $username = 'testuser_' . time();
        $hash = encryptPassword('testpassword');
        setUser($this->connection, $username, $hash, 'test.jpg');
        $this->testUserId = getId($this->connection, $username);
        
        // Test console creation
        $consoleName = 'TestConsole_' . time();
        $maker = 'TestMaker';
        $price = 299.99;
        $image = 'console.jpg';
        $comment = 'Test console comment';
        $dateAdquisition = '2023-01-01';
        
        setConsole($this->connection, $consoleName, $maker, $price, $image, $comment, $dateAdquisition, $this->testUserId);
        
        // Test get console by ID (we need to find the ID first)
        $consoles = getConsolesPagination($this->connection, $this->testUserId, 0);
        $testConsole = null;
        while ($console = $consoles->fetch_assoc()) {
            if ($console['consolename'] === $consoleName) {
                $testConsole = $console;
                break;
            }
        }
        
        $this->assertNotNull($testConsole);
        $this->testConsoleId = $testConsole['id'];
        
        // Test get console by ID
        $consoleData = getConsoleById($this->connection, $this->testConsoleId);
        $this->assertEquals($consoleName, $consoleData['consolename']);
        $this->assertEquals($maker, $consoleData['maker']);
        $this->assertEquals($price, $consoleData['price']);
        
        // Test check if console exists
        $this->assertEquals(EXISTSERROR, checkIfConsoleExists($this->connection, $consoleName, $this->testUserId));
        $this->assertEquals(NOERROR, checkIfConsoleExists($this->connection, 'nonexistentconsole', $this->testUserId));
        
        // Test update console
        $newConsoleName = 'UpdatedConsole_' . time();
        updateConsoleData($this->connection, $newConsoleName, $maker, $price, $image, $comment, $dateAdquisition, $this->testConsoleId, $image, $this->testUserId);
        
        $updatedConsole = getConsoleById($this->connection, $this->testConsoleId);
        $this->assertEquals($newConsoleName, $updatedConsole['consolename']);
    }

    public function testVideogameOperations()
    {
        // First create test user, genre, and console
        $username = 'testuser_' . time();
        $hash = encryptPassword('testpassword');
        setUser($this->connection, $username, $hash, 'test.jpg');
        $this->testUserId = getId($this->connection, $username);
        
        $genre = 'TestGenre_' . time();
        setGenre($this->connection, $genre, 'genre.jpg');
        $genres = getGenres($this->connection);
        foreach ($genres as $g) {
            if ($g['genre'] === $genre) {
                $this->testGenreId = $g['id'];
                break;
            }
        }
        
        $consoleName = 'TestConsole_' . time();
        setConsole($this->connection, $consoleName, 'TestMaker', 299.99, 'console.jpg', 'Test comment', '2023-01-01', $this->testUserId);
        $consoles = getConsolesPagination($this->connection, $this->testUserId, 0);
        while ($console = $consoles->fetch_assoc()) {
            if ($console['consolename'] === $consoleName) {
                $this->testConsoleId = $console['id'];
                break;
            }
        }
        
        // Test videogame creation
        $videogameName = 'TestVideogame_' . time();
        $price = 59.99;
        $image = 'videogame.jpg';
        $comment = 'Test videogame comment';
        $dateAdquisition = '2023-01-01';
        
        setVideogame($this->connection, $videogameName, $this->testConsoleId, $this->testGenreId, $image, $comment, $price, $dateAdquisition, $this->testUserId);
        
        // Test get videogame by ID (we need to find the ID first)
        $videogames = getVideogamesPagination($this->connection, $this->testUserId, 0);
        $testVideogame = null;
        while ($videogame = $videogames->fetch_assoc()) {
            if ($videogame['videogamename'] === $videogameName) {
                $testVideogame = $videogame;
                break;
            }
        }
        
        $this->assertNotNull($testVideogame);
        
        // Test check if videogame exists
        $this->assertEquals(EXISTSERROR, checkIfVideogameExists($this->connection, $videogameName, $this->testUserId));
        $this->assertEquals(NOERROR, checkIfVideogameExists($this->connection, 'nonexistentvideogame', $this->testUserId));
    }

    public function testCountFunctions()
    {
        // Create test user
        $username = 'testuser_' . time();
        $hash = encryptPassword('testpassword');
        setUser($this->connection, $username, $hash, 'test.jpg');
        $this->testUserId = getId($this->connection, $username);
        
        // Test count functions
        $consoleCount = countConsoles($this->connection, $this->testUserId);
        $genreCount = countGenres($this->connection);
        $videogameCount = countVideogames($this->connection, $this->testUserId);
        
        $this->assertIsInt($consoleCount);
        $this->assertIsInt($genreCount);
        $this->assertIsInt($videogameCount);
        $this->assertGreaterThanOrEqual(0, $consoleCount);
        $this->assertGreaterThanOrEqual(0, $genreCount);
        $this->assertGreaterThanOrEqual(0, $videogameCount);
    }

    public function testSumPrices()
    {
        // Create test user
        $username = 'testuser_' . time();
        $hash = encryptPassword('testpassword');
        setUser($this->connection, $username, $hash, 'test.jpg');
        $this->testUserId = getId($this->connection, $username);
        
        // Test sum prices functions
        $consoleSum = getSumPricesConsoles($this->connection, $this->testUserId);
        $videogameSum = getSumPricesVideogames($this->connection, $this->testUserId);
        
        $this->assertIsInt($consoleSum);
        $this->assertIsInt($videogameSum);
        $this->assertGreaterThanOrEqual(0, $consoleSum);
        $this->assertGreaterThanOrEqual(0, $videogameSum);
    }
}
