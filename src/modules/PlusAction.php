<?php 

// we will count sum here

declare(strict_types=1);

namespace App\Modules;

use App\AbstractBaseAction;

class PlusAction extends AbstractBaseAction {

    public function execute(): void {
                
        $this->logger->info("Started plus operation \r\n");
        $this->processFile();
        $this->logger->info("Finished plus operation \r\n");
    }


    /**
     * count result
     * @param int $value1
     * @param int $value2
     * @return int
     */
    public function countResult(int $value1, int $value2) : int
    {
        return $value2 + $value1;
    }
    
}