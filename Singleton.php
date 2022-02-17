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
    
    // @TODO Implement Singleton functionality
    private static $instance;

    /**
     * Private constructor function for singleton class 
     */
    private function __construct()
    {
        echo "called...";
    }

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
        // @TODO Validate & sanitize $name
        if(trim($name)) {
            $name = filter_var($name, FILTER_SANITIZE_ADD_SLASHES);
            echo "The value of 'name' is '{$name}'";
            return true;
        }

        echo "name parameter required.";
    }
    
    /**
     * Query by user name
     * 
     * @param string $name User-provided name
     */
    public static function userQuery($name) {
        // @TODO Validate & sanitize $name
        $name = filter_var($name, FILTER_SANITIZE_ADD_SLASHES);
        mysql_query("SELECT * FROM `test` WHERE `name` = '{$name}' LIMIT 1");
    }
    
    /**
     * Output the contents of a file
     * 
     * @param string $path User-provided file path
     */
    public static function userFile($path) {
        // @TODO Validate & sanitize $path
        if($path && file_exists($path)) {
           return readfile($path);
        }

        echo "not found";
    }
    
    /**
     * Nested conditions
     */
    public static function nestedConditions() {
        // @TODO Untangle nested conditions
        if ($conditionA && $conditionB && $conditionC) {
            echo 'ABC';
        } else if($conditionA && !$conditionB) {
            echo 'B';
        } else if($conditionA && $conditionB && !$conditionC) {
            echo 'C';
        }

        echo 'A';
    }
    
    /**
     * Return statements
     * 
     * @return boolean
     */
    public static function returnStatements() {
        // @TODO Fix
        // reduced to 1 condition.
        if ($conditionA) {
            echo 'A';
            return true;
        }

        return false;
    }
    
    /**
     * Null coalescing
     */
    public static function nullCoalescing() {
        // $_REQUEST contains contents from both $_GET and $_POST so I used it and set $name variable first 
        // and if condition true then variable value changed.
        $name = 'nobody';
        if (isset($_REQUEST['name'])) {
            $name = $_REQUEST['name'];
        }

        return $name;
    }
    
    /**
     * Method chaining
     */
    public static function methodChained() {
        // @TODO Implement method chaining
        $mail->to('myself@domain.com')
        ->subject('Test')
        ->body('Hello World!')
        ->send()
        ;
    }
    
    /**
     * Immutables are hard to find
     */
    public static function checkValue($value) {
        $result = null;
        
        // @TODO Make all the immutable values (int, string) in this class 
        // easily replaceable
        switch ($value) {
            case 'stringA':
                $result = 1;
                break;
                
            case 'stringB':
                $result = 2;
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
        // @TODO Implement RegEx and return type; validate & sanitize input
        return preg_match('#^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])$#', $time24Hour);
    }
    
}

/*EOF*/
