<?php

use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    public function testValidateUserName()
    {
        // Test empty username
        $this->assertEquals(EMPTYERROR, validateUserName(''));
        
        // Test username too short
        $this->assertEquals(MINLONGERROR, validateUserName('abc'));
        
        // Test username too long
        $longUsername = str_repeat('a', MAXUSERNAMELENGTH + 1);
        $this->assertEquals(MAXLONGERROR, validateUserName($longUsername));
        
        // Test valid username
        $this->assertEquals(NOERROR, validateUserName('validuser'));
    }

    public function testValidateConsoleName()
    {
        // Test empty console name
        $this->assertEquals(EMPTYERROR, validateConsoleName(''));
        
        // Test console name too short
        $this->assertEquals(MINLONGERROR, validateConsoleName('abc'));
        
        // Test console name too long
        $longConsoleName = str_repeat('a', MAXCONSOLENAMELENGTH + 1);
        $this->assertEquals(MAXLONGERROR, validateConsoleName($longConsoleName));
        
        // Test valid console name
        $this->assertEquals(NOERROR, validateConsoleName('PlayStation 5'));
    }

    public function testValidateVideoGameName()
    {
        // Test empty video game name
        $this->assertEquals(EMPTYERROR, validateVideoGameName(''));
        
        // Test video game name too short
        $this->assertEquals(MINLONGERROR, validateVideoGameName('abc'));
        
        // Test video game name too long
        $longGameName = str_repeat('a', MAXVIDEOGAMENAMELENGTH + 1);
        $this->assertEquals(MAXLONGERROR, validateVideoGameName($longGameName));
        
        // Test valid video game name
        $this->assertEquals(NOERROR, validateVideoGameName('The Legend of Zelda'));
    }

    public function testValidateMaker()
    {
        // Test empty maker
        $this->assertEquals(EMPTYERROR, validateMaker(''));
        
        // Test maker too short
        $this->assertEquals(MINLONGERROR, validateMaker('abc'));
        
        // Test maker too long
        $longMaker = str_repeat('a', MAXMAKERLENGTH + 1);
        $this->assertEquals(MAXLONGERROR, validateMaker($longMaker));
        
        // Test valid maker
        $this->assertEquals(NOERROR, validateMaker('Nintendo'));
    }

    public function testValidateGenre()
    {
        // Test empty genre
        $this->assertEquals(EMPTYERROR, validateGenre(''));
        
        // Test genre too short
        $this->assertEquals(MINLONGERROR, validateGenre('ab'));
        
        // Test genre too long
        $longGenre = str_repeat('a', MAXGENRELENGTH + 1);
        $this->assertEquals(MAXLONGERROR, validateGenre($longGenre));
        
        // Test valid genre
        $this->assertEquals(NOERROR, validateGenre('Action'));
    }

    public function testValidatePrice()
    {
        // Test empty price
        $this->assertEquals(EMPTYERROR, validatePrice(''));
        
        // Test price too low
        $this->assertEquals(MINPRICEERROR, validatePrice(-1));
        
        // Test price too high
        $this->assertEquals(MAXPRICEERROR, validatePrice(MAXPRICE + 1));
        
        // Test valid price
        $this->assertEquals(NOERROR, validatePrice(100));
    }

    public function testValidateComment()
    {
        // Test valid short comment
        $this->assertEquals(NOERROR, validateComment('Short comment'));
        
        // Test comment too long
        $longComment = str_repeat('a', MAXCOMMENTLENGTH + 1);
        $this->assertEquals(MAXCOMMENTLENGTHERROR, validateComment($longComment));
    }

    public function testCheckPassword()
    {
        // Test empty password
        $this->assertEquals(EMPTYERROR, checkPassword(''));
        
        // Test valid password
        $this->assertEquals(NOERROR, checkPassword('password123'));
    }

    public function testCheckRepassword()
    {
        // Test empty repassword
        $this->assertEquals(EMPTYERROR, checkRepassword('password', ''));
        
        // Test passwords don't match
        $this->assertEquals(REPASSWORDERROR, checkRepassword('password', 'different'));
        
        // Test valid repassword
        $this->assertEquals(NOERROR, checkRepassword('password', 'password'));
    }

    public function testEncryptPassword()
    {
        $password = 'testpassword';
        $hash = encryptPassword($password);
        
        // Test that hash is generated
        $this->assertNotEmpty($hash);
        
        // Test that hash is different from original password
        $this->assertNotEquals($password, $hash);
        
        // Test that hash can be verified
        $this->assertTrue(checkHash($password, $hash));
    }

    public function testFiltering()
    {
        // Test HTML special characters
        $input = '<script>alert("test")</script>';
        $filtered = filtering($input);
        $this->assertStringNotContainsString('<script>', $filtered);
        
        // Test trimming
        $input = '  test  ';
        $filtered = filtering($input);
        $this->assertEquals('test', $filtered);
        
        // Test stripslashes
        $input = 'test\\"value';
        $filtered = filtering($input);
        $this->assertEquals('test"value', $filtered);
    }
}
