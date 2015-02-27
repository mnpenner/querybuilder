<?php

class SimilarStringConstraint extends PHPUnit_Framework_Constraint {
    /**
     * @var string
     */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value) {
        parent::__construct();
        $this->value = $value;
    }

    protected function normalize($str) {
        return mb_strtolower(preg_replace('~[ \t\n\r\0\x0B\x0C]+~', ' ', trim($str, " \t\n\r\0\x0B\x0C")),'utf8');
    }

    /**
     * Evaluates the constraint for parameter $other
     *
     * If $returnResult is set to false (the default), an exception is thrown
     * in case of a failure. null is returned otherwise.
     *
     * If $returnResult is true, the result of the evaluation is returned as
     * a boolean value instead: true in case of success, false in case of a
     * failure.
     *
     * @param  mixed  $other Value or object to evaluate.
     * @param  string $description Additional information about the test
     * @param  bool   $returnResult Whether to return a result or throw an exception
     *
     * @return mixed
     * @throws PHPUnit_Framework_ExpectationFailedException
     */
    public function evaluate($other, $description = '', $returnResult = false) {
        $success = $this->normalize($other) === $this->normalize($this->value);

        if($returnResult) {
            return $success;
        }

        if(!$success) {
            $f = null;

            // if both values are strings, make sure a diff is generated
            if(is_string($this->value) && is_string($other)) {
                $f = new SebastianBergmann\Comparator\ComparisonFailure(
                    $this->value,
                    $other,
                    $this->value,
                    $other
                );
            }

            $this->fail($other, $description, $f);
        }
    }

    /**
     * Returns the description of the failure
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * @param  mixed $other Evaluated value or object.
     *
     * @return string
     */
    protected function failureDescription($other) {
        return "two strings are equal, ignoring whitespace and case";
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString() {
        return 'is similar to ' .
        $this->exporter->export($this->value);

    }
}
