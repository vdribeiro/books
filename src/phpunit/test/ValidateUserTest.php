<?php
// This script is ValidateUserTest.php

// Include the code to be tested
require_once ('../lib/Validator.php');

// Tests the ValidateUser class
class ValidateUserTest extends Test {

    var $validator; // Instance of class to test

    // Instantiate validator
    function ValidateUserTest() {
        // Instantiate the class to be tested
        $this->validator= new ValidateUser('username');
    }

    // Test a valid username
    function testValidUser () {
        // Method should return true so test with Assert::equalsTrue
        Assert::equalsTrue($this->validator->isValid(),
            'User is valid but returned isValid() false');
    }

    // Test username containing invalid characters
    function testInvalidChars () {
        // Reset the errors
        $this->validator->errors=array();
        // Set test data
        $this->validator->user='user%name';
        // As this is called by a constructor, call it again
        $this->validator->validate();
        // Method should return false so test with Assert::equalsFalse
        Assert::equalsFalse($this->validator->isValid(),
            'User contains bad chars but isValid() returned true');
    }

    // Test username that is too short
    function testInvalidShort () {
        // Reset the errors
        $this->validator->errors=array();
        // Set test data
        $this->validator->user='user';
        // As this is called by a constructor, call it again
        $this->validator->validate();
        // Method should return false so test with Assert::equalsFalse
        Assert::equalsFalse($this->validator->isValid(),
            'User is too short but isValid() returned true');
    }

    // Test username that is too long
    function testInvalidLong () {
        // Reset the errors
        $this->validator->errors=array();
        // Set test data
        $this->validator->user='usernameusernameusername';
        // As this is called by a constructor, call it again
        $this->validator->validate();
        // Method should return false so test with Assert::equalsFalse
        Assert::equalsFalse($this->validator->isValid(),
            'User is too long but isValid() returned true');
    }
}
?>