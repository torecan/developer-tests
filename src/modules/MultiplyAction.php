<?php 

// here we will make multiplication

declare(strict_types=1);

namespace App\Modules;

use App\AbstractBaseAction;

class MultiplyAction extends AbstractBaseAction {

    /**
     * execute action
     */
    public function execute(): void {
                
        $this->logger->info("Started multiply operation \r\n");
        $this->processFile();
        $this->logger->info("Finished multiply operation \r\n");
    }


    /**
     * count result
     * @param int $value1
     * @param int $value2
     * @return int
     */
    public function countResult(int $value1, int $value2) : int
    {
        return $value2 * $value1;
    }
    
}