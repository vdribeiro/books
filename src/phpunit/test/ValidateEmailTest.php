<?php
require_once ('../lib/Validator.php');

// Tests the ValidateEmail class
class ValidateEmailTest extends Test {

    var $validator;

    function ValidateEmailTest() {
        $this->validator= new ValidateEmail('name@domain.com');
    }

    function testValidEmail () {
        $this->validator->validate();
        Assert::equalsTrue($this->validator->isValid(),
            'Email is valid but returned isValid() false');
    }

    function testInvalidChars () {
        $this->validator->errors=array();
        $this->validator->email='name_domain.com';
        $this->validator->validate();
        Assert::equalsFalse($this->validator->isValid(),
            'Email contains bad chars but isValid() returned true');
    }

    function testInvalidLong () {
        $this->validator->errors=array();
        $this->validator->email=str_pad('name@domain.com',86,
                                        'pad',STR_PAD_LEFT);
        $this->validator->validate();
        Assert::equalsFalse($this->validator->isValid(),
            'Email is too long but isValid() returned true');
    }
}
?>