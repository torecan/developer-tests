<?php 

declare(strict_types=1);

namespace App;
use App\Logger;

abstract class AbstractBaseAction implements ActionInterface {

    private const RESULT_FILE = "./results/result.csv";
    
    protected string $file;
    protected string $logfile;
    protected $logger;
    protected $resultHandler;

    public function __construct(string $file)
    {
        $this->file = $file;
        $this->logger = Logger::getLogger();
        $this->logfile = Logger::getLogFilePath();
        $this->prepareFiles();
        $this->prepareHanders();

        $this->execute();
    }

    abstract public function execute(): void;
    abstract public function countResult(int $value1, int $value2): int|float;


    /**
     * check and delete main files before execution
     */
    protected function prepareFiles() : void
    {

        $this->validateResourceFile();

        //delete log file if it is already exists
        if(file_exists($this->logfile)) {
            unlink($this->logfile);
        }

        $folder = dirname(self::RESULT_FILE); // Extract the folder path

        // Check if the folder exists; if not, create it
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true); // Create the folder with full permissions
        }

        //delete result file if it already exists
        if(file_exists(self::RESULT_FILE)) {
            unlink(self::RESULT_FILE);
        }

    }

    /**
     * prepare handlers to writing
     * @throws Exception
     */
    private function prepareHanders() : void
    {

        $this->resultHandler = fopen(self::RESULT_FILE, "a+");

        if($this->resultHandler === false) {
            throw new \Exception("Result File cannot be open for writing");
        }
    }
    
    /**
     * main function, process the count
     */
    protected function processFile() : void
    {
        $handle = fopen($this->file,'r');
        while ( ($line = fgetcsv($handle) ) !== FALSE ) {
            list($value1, $value2) = $this->prepareValues($line[0]);
            $result = $this->countResult($value1, $value2);
            if($this->isResultValid($result)) {
                $this->writeSuccessResult($value1, $value2, $result);
            } else {
                $this->wrongResultLog($value1, $value2);
            }
        }
    }

        /**
     * prepare numbers before action, explode it from csv string
     * @param string $line
     * @return array<int,int>
     */
    private function prepareValues(string $line) : array
    {
        $line = explode(";", $line);
        $value1 = $this->prepareNumber($line[0]);
        $value2 = $this->prepareNumber($line[1]);
        return [$value1, $value2];
    }

        /**
     * prepare number before action
     * @param string $value
     * @return int
     */
    private function prepareNumber(string $value) : int
    {
        return intval(trim($value));
    }


     /**
     * validate if result is valid
     * @param int|float $result
     * @return bool
     */
    private function isResultValid(int|float $result) : bool
    {
        return $result > 0;
    }


    /**
     * @return bool
     * @throws Exception
     */
    private function validateResourceFile() : void {
        if($this->file === null) {
            throw new \Exception("Please define file with data");
        }

        if(!file_exists($this->file)) {
            throw new \Exception("Please define file with data");
        }

        if(!is_readable($this->file)) {
            throw new \Exception("We have not rights to read this file");
        }
    }



    /**
     * prepare info and save it in result file
     * @param int $value1
     * @param int $value2
     * @param int|float $result
     */
    private function writeSuccessResult(int $value1, int $value2, int|float $result) : void
    {
        $message = implode(";", [$value1, $value2, $result]);
        $this->successInfo($message);
    }


    /**
     * write message in result file
     * @param string $message
     */
    private function successInfo(string $message) : void
    {
        $message = $message."\r\n";
        fwrite($this->resultHandler, $message);
    }


    /**
     * write in logs if numbers give wrong result
     * @param int $value1
     * @param int $value2
     * @throws Exception
     */
    protected function wrongResultLog(int $value1, int $value2) : void
    {
        $message = "numbers ".$value1 . " and ". $value2." are wrong";
        $this->logger->info($message);
    }

    /**
     * close opened handlers
     */
    private function closeHandlers() : void
    {
        fclose($this->resultHandler);
    }

    /**
     * destructor
     */
    public function __destruct()
    {
        $this->closeHandlers();
    }

}