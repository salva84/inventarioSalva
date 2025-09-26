<?php

use PHPUnit\Framework\TestCase;

class CRUDTest extends TestCase
{
    private function getConnection() {
        $connection = new mysqli('db', 'root', 'root', 'inventory_new');
        if ($connection->connect_error) {
            return null;
        }
        return $connection;
    }
    public function testExecuteQuery()
    {
        // Test with parameters
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        $sql = "SELECT 1 as test_value";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->assertNotFalse($result);
        
        $row = $result->fetch_assoc();
        $this->assertEquals(1, $row['test_value']);
        
        $connection->close();
    }

    public function testExecuteUpdate()
    {
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        // Test update with parameters
        $sql = "SELECT 1 as test_value";
        $result = executeUpdate($connection, $sql);
        $this->assertTrue($result);
        
        $connection->close();
    }

    public function testExecuteInsert()
    {
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        // Test insert (should be same as executeUpdate)
        $sql = "SELECT 1 as test_value";
        $result = executeInsert($connection, $sql);
        $this->assertTrue($result);
        
        $connection->close();
    }

    public function testExecuteDelete()
    {
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        // Test delete (should be same as executeUpdate)
        $sql = "SELECT 1 as test_value";
        $result = executeDelete($connection, $sql);
        $this->assertTrue($result);
        
        $connection->close();
    }

    public function testFetchSingleResult()
    {
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        $sql = "SELECT 1 as test_value, 'test' as test_string";
        $result = fetchSingleResult($connection, $sql);
        
        $this->assertIsArray($result);
        $this->assertEquals(1, $result['test_value']);
        $this->assertEquals('test', $result['test_string']);
        
        $connection->close();
    }

    public function testFetchSingleValue()
    {
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        $sql = "SELECT 42 as test_value";
        $result = fetchSingleValue($connection, $sql);
        
        $this->assertEquals(42, $result);
        
        $connection->close();
    }

    public function testFetchAllResults()
    {
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        $sql = "SELECT 1 as id, 'first' as name UNION SELECT 2 as id, 'second' as name";
        $results = fetchAllResults($connection, $sql);
        
        $this->assertIsArray($results);
        $this->assertCount(2, $results);
        $this->assertEquals(1, $results[0]['id']);
        $this->assertEquals('first', $results[0]['name']);
        $this->assertEquals(2, $results[1]['id']);
        $this->assertEquals('second', $results[1]['name']);
        
        $connection->close();
    }

    public function testGetRecords()
    {
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        $result = getRecords($connection, 'genres', 'id, genre', 'WHERE 1=1', [], 'genre', 'LIMIT 5');
        $this->assertNotFalse($result);
        
        $connection->close();
    }

    public function testGetRecordById()
    {
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        // Get first genre
        $genres = getRecords($connection, 'genres', 'id', 'WHERE 1=1', [], '', 'LIMIT 1');
        if ($genres && $genre = $genres->fetch_assoc()) {
            $genreId = $genre['id'];
            $result = getRecordById($connection, 'genres', $genreId);
            $this->assertIsArray($result);
            $this->assertEquals($genreId, $result['id']);
        }
        
        $connection->close();
    }

    public function testCountRecords()
    {
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        $count = countRecords($connection, 'genres');
        $this->assertIsInt($count);
        $this->assertGreaterThanOrEqual(0, $count);
        
        $connection->close();
    }

    public function testSumPrices()
    {
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        // Test with a user that might not exist
        $sum = sumPrices($connection, 'consoles', 999999);
        $this->assertIsInt($sum);
        $this->assertEquals(0, $sum);
        
        $connection->close();
    }

    public function testDeleteRecord()
    {
        $connection = $this->getConnection();
        if (!$connection || $connection->connect_error) {
            $this->markTestSkipped('Database connection failed');
        }
        
        // Test delete with non-existent record (should not fail)
        $result = deleteRecord($connection, 'genres', 'id = ?', [999999]);
        $this->assertTrue($result);
        
        $connection->close();
    }
}
