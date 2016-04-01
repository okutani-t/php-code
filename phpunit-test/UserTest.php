<?php
require_once "vendor/autoload.php";
require_once "User.php";

class UserTest extends PHPUnit_Framework_TestCase
{
    protected $user;
    // test the talk method
    public function testTalk() {
        // make an instance of the user
        $user = new User();

        // use assertEquals to ensure the greeting is what you
        $expected = "Hello world!";
        $actual = $user->talk();
        $this->assertEquals($expected, $actual);
    }

    protected function setUp() {
        $this->user = new User();
        $this->user->setName("Tom");
    }

    protected function tearDown() {
        unset($this->user);
    }

}
