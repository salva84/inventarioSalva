<?php

use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    private $connection;
    private $testUserId;
    private $testUsername;
    private $testPassword;

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
        
        // Crear usuario de prueba
        $this->testUsername = 'testuser_' . time();
        $this->testPassword = 'testpassword123';
        $hash = encryptPassword($this->testPassword);
        setUser($this->connection, $this->testUsername, $hash, 'test.jpg');
        $this->testUserId = getId($this->connection, $this->testUsername);
    }

    protected function tearDown(): void
    {
        // Limpiar usuario de prueba
        if ($this->connection && $this->testUserId) {
            $this->connection->query("DELETE FROM users WHERE id = {$this->testUserId}");
        }
    }

    public function testUserRegistration()
    {
        $username = 'newuser_' . time();
        $password = 'newpassword123';
        $hash = encryptPassword($password);
        $image = 'newuser.jpg';
        
        // Test user creation
        setUser($this->connection, $username, $hash, $image);
        
        // Verify user was created
        $userId = getId($this->connection, $username);
        $this->assertNotNull($userId);
        
        // Verify password hash
        $userHash = getHash($this->connection, $username);
        $this->assertEquals($hash, $userHash);
        
        // Verify profile
        $profile = getProfile($this->connection, $userId);
        $this->assertEquals($username, $profile['username']);
        $this->assertEquals($image, $profile['image']);
        
        // Clean up
        $this->connection->query("DELETE FROM users WHERE id = {$userId}");
    }

    public function testUserLogin()
    {
        // Test correct credentials
        $userHash = getHash($this->connection, $this->testUsername);
        $this->assertNotNull($userHash);
        
        $isValidPassword = checkHash($this->testPassword, $userHash);
        $this->assertTrue($isValidPassword);
        
        // Test incorrect password
        $isInvalidPassword = checkHash('wrongpassword', $userHash);
        $this->assertFalse($isInvalidPassword);
    }

    public function testUserExistsCheck()
    {
        // Test existing user
        $this->assertEquals(EXISTSERROR, checkIfUserExists($this->connection, $this->testUsername));
        
        // Test non-existing user
        $this->assertEquals(NOERROR, checkIfUserExists($this->connection, 'nonexistentuser'));
        
        // Test empty username
        $this->assertEquals(EMPTYERROR, checkIfUserExists($this->connection, ''));
    }

    public function testPasswordValidation()
    {
        // Test valid password
        $this->assertEquals(NOERROR, checkPassword($this->testPassword));
        
        // Test empty password
        $this->assertEquals(EMPTYERROR, checkPassword(''));
        
        // Test password confirmation
        $this->assertEquals(NOERROR, checkRepassword($this->testPassword, $this->testPassword));
        $this->assertEquals(REPASSWORDERROR, checkRepassword($this->testPassword, 'differentpassword'));
        $this->assertEquals(EMPTYERROR, checkRepassword($this->testPassword, ''));
    }

    public function testSessionManagement()
    {
        // Test session start
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Test user ID encoding/decoding
        $encodedUserId = base64_encode($this->testUserId);
        $decodedUserId = base64_decode($encodedUserId);
        $this->assertEquals($this->testUserId, $decodedUserId);
        
        // Test session user storage
        $_SESSION['user'] = $encodedUserId;
        $this->assertEquals($encodedUserId, $_SESSION['user']);
    }

    public function testPasswordHashing()
    {
        $password = 'testpassword';
        
        // Test password hashing
        $hash1 = encryptPassword($password);
        $hash2 = encryptPassword($password);
        
        // Hashes should be different (salt)
        $this->assertNotEquals($hash1, $hash2);
        
        // Both should verify correctly
        $this->assertTrue(checkHash($password, $hash1));
        $this->assertTrue(checkHash($password, $hash2));
        
        // Wrong password should not verify
        $this->assertFalse(checkHash('wrongpassword', $hash1));
    }

    public function testUserProfileRetrieval()
    {
        // Test get user profile
        $profile = getProfile($this->connection, $this->testUserId);
        $this->assertIsArray($profile);
        $this->assertEquals($this->testUsername, $profile['username']);
        $this->assertEquals('test.jpg', $profile['image']);
        
        // Test get user ID
        $userId = getId($this->connection, $this->testUsername);
        $this->assertEquals($this->testUserId, $userId);
        
        // Test get user hash
        $userHash = getHash($this->connection, $this->testUsername);
        $this->assertNotNull($userHash);
        $this->assertTrue(checkHash($this->testPassword, $userHash));
    }

    public function testUserValidation()
    {
        // Test username validation
        $this->assertEquals(NOERROR, validateUserName($this->testUsername));
        $this->assertEquals(EMPTYERROR, validateUserName(''));
        $this->assertEquals(MINLONGERROR, validateUserName('abc'));
        
        $longUsername = str_repeat('a', MAXUSERNAMELENGTH + 1);
        $this->assertEquals(MAXLONGERROR, validateUserName($longUsername));
    }
}
