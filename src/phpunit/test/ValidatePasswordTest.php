<?php
require_once ('../lib/Validator.php');

// Tests the ValidatePassword class
class ValidatePasswordTest extends Test {

    var $validator;

    function ValidatePasswordTest() {
        $this->validator= new ValidatePassword('password','password');
    }

    function testValidPassword () {
        $this->validator->validate();
        Assert::equalsTrue($this->validator->isValid(),
            'Password is valid but returned isValid() false');
    }

    function testInvalidChars () {
        $this->validator->errors=array();
        $this->validator->pass='pass%word';
        $this->validator->conf='pass%word';
        $this->validator->validate();
        Assert::equalsFalse($this->validator->isValid(),
            'Password contains bad chars but isValid() returned true');
    }

    function testInvalidShort () {
        $this->validator->errors=array();
        $this->validator->pass='pass';
        $this->validator->conf='pass';
        $this->validator->validate();
        Assert::equalsFalse($this->validator->isValid(),
            'Password is too short but isValid() returned true');
    }

    function testInvalidLong () {
        $this->validator->errors=array();
        $this->validator->pass='passwordpasswordpassword';
        $this->validator->conf='passwordpasswordpassword';
        $this->validator->validate();
        Assert::equalsFalse($this->validator->isValid(),
            'Password is too long but isValid() returned true');
    }

    function testMismatch () {
        $this->validator->errors=array();
        $this->validator->pass='password';
        $this->validator->conf='mismatch';
        $this->validator->validate();
        Assert::equalsFalse($this->validator->isValid(),
            'Passwords do not match but isValid() returned true');
    }
}
?>