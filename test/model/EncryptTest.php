<?php
/**
 * Created by PhpStorm.
 * User: WhiteDumb
 * Date: 1/4/2019
 * Time: 7:27 AM
 */

require("../../php/model/encrypt.php");

class EncryptTest extends \PHPUnit\Framework\TestCase
{
    public function testEncrypt()
    {
        $password = "testPassword123";
        $hashedPassword = "9eb57095f3cc2271bf91100e5c8661d6";
        $encrypt = new Encrypt();

        $this->assertEquals($hashedPassword, $encrypt->encrypt($password));
    }

    public function testCheckPassword()
    {
        $truePassword = "testPassword123";
        $wrongPassword = "badPassword";
        $hashedPassword = "9eb57095f3cc2271bf91100e5c8661d6";
        $fakeHashedPassword = "1ff24545f2cc3542bf15845e5c1234e1";
        $encrypt = new Encrypt();

        $this->assertTrue($encrypt->checkPassword($truePassword, $hashedPassword));
        $this->assertFalse($encrypt->checkPassword($wrongPassword, $hashedPassword));
        $this->assertFalse($encrypt->checkPassword($truePassword, $fakeHashedPassword));
    }

}
