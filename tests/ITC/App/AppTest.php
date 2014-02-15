<?php

namespace ITC\App;

class AppTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var App
     */
    protected $skeleton;

    protected function setUp()
    {
        $this->skeleton = new App;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\ITC\App\App', $actual);
    }

    /**
     * @expectedException \ITC\App\Exception\LogicException
     */
    public function testException()
    {
        throw new Exception\LogicException;
    }
}
