<?php

/**
 * Please fix the items marked with "@TODO" in this class
 * 
 * Follow the https://www.php-fig.org/psr/psr-2/ coding style guide.
 * 
 * One exception to PSR-2: opening braces MUST always be on the same line 
 * for classes, methods, functions, and control structures
 */
class Singleton {
    
    /**
     * Use constants for immutable types instead of variables
     * Use descriptive names
     */
    const STRING_A     = 'A';
    const STRING_A_LONG = 'stringA';
    const STRING_B_LONG = 'stringB';
    const STRING_NON_A = '^A';
    const STRING_NON_B = '^B';
    const STRING_NON_C = '^C';
    const STRING_ABC   = 'ABC';
    const INT_A = 1;
    const INT_B = 2;

    /**
     * Path to files accessible by users
     */
    const FILES_PATH = '/path/to/files';
    
    /**
     * Instance of singleton
     * 
     * @var Singleton
     */
    private static $instance;

    /**
     * Private constructor function for singleton class 
     */
    private function __construct() {}

    /**
     * 
     */
    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Display user name
     * 
     * @param string $name User-provided name
     */
    public static function userEcho($name) {
        // Prevent XSS
        $name = filter_var($name, FILTER_SANITIZE_ADD_SLASHES);
        echo "The value of 'name' is '{$name}'";
    }
    
    /**
     * Query by user name
     * 
     * @param string $name User-provided name
     */
    public static function userQuery($name) {
        // Prevent SQL injections
        $name = mysql_real_escape_string($name);
        mysql_query("SELECT * FROM `test` WHERE `name` = '{$name}' LIMIT 1");
    }
    
    /**
     * Output the contents of a file
     * 
     * @param string $path User-provided file path
     */
    public static function userFile($path) {
        // User paths are relative to this root
        $root = self::FILES_PATH;

        // The main point is to never allow users to perform directory traversal
        // Special characters like "." and ".." and direct root access should be forbidden
        // Validate relative path, file name and extension
        if (!preg_match('%^(?:allowed_path_a|allowed_path_b)\/\w+\.(?:ext|png|jpe?g)$%i', $path)) {
            throw new Exception('Invalid file path');
        }

        // File not found; also check that the path points to a file, not a directory
        if (!is_file("$root/$path")) {
            throw new Exception('File not found');
        }

        readfile("$root/$path");
    }
    
    /**
     * Nested conditions
     */
    public static function nestedConditions() {
        do {
            if (!$conditionA) {
                echo self::STRING_NON_A;
                break;
            }

            if (!$conditionB) {
                echo self::STRING_NON_B;
                break;
            }

            if (!$conditionC) {
                echo self::STRING_NON_C;
                break;
            }

            echo self::STRING_ABC;
            
        } while(false);
    }
    
    /**
     * Return statements
     * 
     * @return boolean
     */
    public static function returnStatements() {
        if ($conditionA) {
            echo self::STRING_A;
        }

        // Implicit boolean conversion
        return !!$conditionA;
    }
    
    /**
     * Null coalescing
     */
    public static function nullCoalescing() {
        return $_GET['name'] ?? $_POST['name'] ?? 'nobody';
    }
    
    /**
     * Method chaining
     */
    public static function methodChained() {
        return $this;
    }
    
    /**
     * Immutables are hard to find
     */
    public static function checkValue($value) {
        $result = null;

        // We should't use constants (strings, ints) locally
        // Store them as class constants instead
        switch ($value) {
            case self::STRING_A_LONG:
                $result = self::INT_A;
                break;

            case self::STRING_B_LONG:
                $result = self::INT_B;
                break;
        }
  
        return $result;
    }
    
    /**
     * Check a string is a 24 hour time
     * 
     * @example "00:00:00", "23:59:59", "20:15"
     * @return boolean
     */
    public static function regexTest($time24Hour) {
        // Does not match "20:15"
        // Falsely matches "0:00:00"
        # return preg_match('#^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])$#', $time24Hour);
        
        // No need to sanitize further, a regex will do
        // [0-9] is equivalent to \d
        // 0 left padding - so [01]\d instad of [01]?\d (02:00 instead of 2:00)
        // DRY - don't repeat yourself, the 00-59 minute/second block can appear once or twice
        // Don't use capturing blocks if you don't need them - (?:) instead of ()
        // preg_match returns 0,1 or false; expected return value is boolean
        return !!preg_match('#^(?:[01]\d|2[0-3])(?:\:[0-5]\d){1,2}$#', $time24Hour);
    }
    
}

/*EOF*/
