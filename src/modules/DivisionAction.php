<?php 

// here we will make division

declare(strict_types=1);

namespace App\Modules;

use App\AbstractBaseAction;

class DivisionAction extends AbstractBaseAction {

    public function execute(): void {
                
        $this->logger->info("Started division operation \r\n");
        $this->processFile();
        $this->logger->info("Finished division operation \r\n");
    }


    /**
     * count result
     * @param int $value1
     * @param int $value2
     * @return int
     */
    public function countResult(int $value1, int $value2) : float
    {
        if($value2 === 0) {
            return 0;
        }

        return $value1 / $value2;
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
     
        if($value2 === 0) {
            $message .= ', is not allowed';
        }

        $this->logger->info($message);
    }
    
}