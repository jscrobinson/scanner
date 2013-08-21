<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2013-08-21 at 15:54:04.
 */
class Scanner_Util_Filter_StringTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Scanner_Util_Filter_String
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Scanner_Util_Filter_String;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers Scanner_Util_Filter_String::underscore
     */
    public function testUnderscore() {
        $camelized = 'ThisIsCamelized';
        $this->assertEquals('this_is_camelized', $this->object->underscore($camelized));
    }

    /**
     * @covers Scanner_Util_Filter_String::underscoreCallback
     * @todo   Implement testUnderscoreCallback().
     */
    public function testUnderscoreCallback() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Scanner_Util_Filter_String::camelizeCallback
     * @todo   Implement testCamelizeCallback().
     */
    public function testCamelizeCallback() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Scanner_Util_Filter_String::camelize
     * @todo   Implement testCamelize().
     */
    public function testCamelize() {
        $underscored = 'this_is_underscored';
        $this->assertEquals('ThisIsUnderscored', $this->object->camelize($underscored));
    }

}
