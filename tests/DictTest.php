<?php
use QueryBuilder\Dict;

class TestDict extends TestCase {
    
    function testSetGet() {
        $d = new Dict();
        $o1 = new \stdClass();
        $o1->a = 1;
        $o1->b = 2;
        $o2 = new \stdClass();
        $o2->b = 3;
        $d[$o1] = 4;
        $this->assertSame($d[$o1],4);
        $d[$o2] = 5;
        $this->assertSame($d[$o2],5);
        $o3 = new \stdClass();
        $o2->c = 6;
        $d[$o3] = $o2;
        $this->assertSame($d[$o3],$o2);
        $this->assertNotSame($d[$o3],$o1);
    }

    function testExistsUnsed() {
        $d = new Dict();
        $o1 = new \stdClass();
        $o2 = new \stdClass();
        $d[$o1] = 1;
        $this->assertTrue(isset($d[$o1]));
        $d[$o2] = null;
        $this->assertTrue(isset($d[$o2]));
        $this->assertTrue(empty($d[$o2]));
        unset($d[$o1]);
        $this->assertFalse(isset($d[$o1]));
        unset($d[$o2]);
        $this->assertFalse(isset($d[$o2]));
        $this->assertTrue(empty($d[$o2]));
    }
}