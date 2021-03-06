<?php

class Scanner_CliHandler extends Scanner_CliHandler_Abstract implements 
        Scanner_Util_Filter_String_RequireInterface {
    
    /**
     *
     * @var Scanner_Option_Interface
     */
    protected $_optionInterface;

    /**
     *
     * @var Scanner_Util_Filter_String_Interface
     */
    protected $_stringInterface;
    
    /**
     *
     * @var array 
     */
    protected $_options = array(
        array('a', 'alltests', Scanner_CliHandler_Option_GetOpt::NO_ARGUMENT, 'Run all tests'),
        array('t', 'test', Scanner_CliHandler_Option_GetOpt::REQUIRED_ARGUMENT, 'Run specified test'),
        array('p', 'path', Scanner_CliHandler_Option_GetOpt::REQUIRED_ARGUMENT, 'The path to scan'),
        array('e', 'extension', Scanner_CliHandler_Option_GetOpt::REQUIRED_ARGUMENT, 'The file extension to scan'),
    );

    /**
     * Sets the object used for string filtering
     * 
     * @param Scanner_Util_Filter_String_Interface $stringInterface
     */
    public function setStringFilterInterface(Scanner_Util_Filter_String_Interface $stringInterface) {
        $this->_stringInterface = $stringInterface;
    }
    
    /**
     * Gets the string filtering object
     * 
     * @return Scanner_Util_Filter_String_Interface
     */
    public function getStringFilterInterface() {
        return $this->_stringInterface;
    }
    
    /**
     * 
     */
    public function run() {
        try {
            $this->_run();
        } 
        catch (Scanner_CliHandler_Exception $e) {
            $this->getOutputInterface()->outputError($e->getMessage() . PHP_EOL);
            $this->outputUsage();
            $this->_logger->error($e->getMessage());
            return $e;
        }
         catch (Scanner_Test_Exception $e) {
            $this->getOutputInterface()->outputError('Error in test "' . $this->_currentTest . '": ' . PHP_EOL . '"' . $e->getMessage() . '"' . PHP_EOL);
            $this->outputUsage();
            $this->_logger->error($e->getMessage());
            return $e;
        }
        return true;
    }

    /**
     * 
     */
    protected function _run() {  
        $this->_optionInterface->parse();
        if ($this->_optionInterface->getOption('alltests', false)) {
            $this->runAllTests();
        } else if ($this->_optionInterface->getOption('test', false) != false) {
            $this->runTest($this->_optionInterface->getOption('test', false));
        } else {
            $this->outputUsage();
        }
    }
    
    /**
     * 
     */
    public function runAllTests() {
        $this->getOutputInterface()->outputMessage('Running all tests');
    }

    /**
     * 
     */
    public function runTest($test) {
        $this->_currentTest = $test;
        $this->getTestInstance($this->_currentTest)->run();
        $this->getOutputInterface()->outputMessage('Running test ' . $test);
    }
    
    /**
     * 
     * @param type $test
     * @return Scanner_Test_Interface
     * @throws Scanner_CliHandler_Exception
     */
    public function getTestInstance($test = null) {
        $testClassName = $this->getTestClassname($test);
        if(!class_exists($testClassName))
        {
            throw new Scanner_CliHandler_Exception('The specified test does not exist.');
        }
        
        return new $testClassName($this->_optionInterface, $this->getOutputInterface(), $this->_logger);
    }
    
    /**
     * 
     * @param string $test
     */
    public function getTestClassname($test = null) {
        $test = is_null($test) ? $this->_currentTest : $test;
        return 'Scanner_Test_' . $this->getStringFilterInterface()->camelize($test);
    }
    
    /**
     * 
     */
    public function outputUsage() {
        $this->getOutputInterface()->output('Usage: ' . basename($_SERVER['PHP_SELF']) . ' --alltests --path=TARGET_PATH' . PHP_EOL);
        $this->getOutputInterface()->output('Options:');
        $this->getOutputInterface()->output($this->_optionInterface->getHelpText());
    }

    
}