<?php

    namespace App\Traits;

    use Exception;

    trait ManagementTaskTrait {
        private $pathTask = __DIR__ . '/../../data/task.json';

        private function getDataTaskFromFile(): array {
            try{
                if(file_exists($this->pathTask) === false) {
                    return [];
                }

                $dataStr = file_get_contents($this->pathTask);
                $data = json_decode($dataStr, true);
               
                $tasks = [];
                if(!is_null($data)){
                    foreach($data as $item) {
                        $tasks[] = $item;
                    }
                }

                return $tasks;
            }catch(Exception){
                throw new \Exception("Failed to read task data.");
            }
        }

        private function saveDataTaskIntoFile(array $data): void {
            try{
                if(file_exists($this->pathTask) === false) {
                    throw new \Exception("No path for task data.");
                }

                file_put_contents($this->pathTask, json_encode($data));
            }catch(Exception){
                throw new \Exception("Failed to save task data.");
            }
        }
    }