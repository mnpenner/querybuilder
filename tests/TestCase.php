<?php
require __DIR__ . '/SimilarStringConstraint.php';

class TestCase extends PHPUnit_Framework_TestCase {

    public static function assertSimilar($expected, $actual, $message = '') {
        $constraint = new SimilarStringConstraint($expected);
        self::assertThat($actual, $constraint, $message);
    }
}