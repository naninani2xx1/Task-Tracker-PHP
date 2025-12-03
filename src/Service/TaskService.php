<?php
namespace App\Service;

use App\Traits\ManagementIDTrait;
use App\Traits\ManagementTaskTrait;
use App\Models\Task;
use App\Enum\Task\Status;
use Exception;

class TaskService {
    use ManagementTaskTrait, ManagementIDTrait;

    public function __construct()
    {
       
    }

    public function add(string $taskName)
    {
        $generateId = $this->generateId();
        $now = date('Y-m-d H:i:s');

        $task = new Task($generateId, $taskName, Status::Todo, $now, $now);
        
        try{
            //read existing data
            $data = $this->getDataTaskFromFile();
    
            $data[] = Task::fromObject($task);
            $this->saveDataTaskIntoFile($data);

            return $task;
        }catch(Exception){
            throw new \Exception("Failed to save task data.");
        }
    }

    public function save(int $taskId, array $updateProps = [])
    {
        $tasks = $this->getDataTaskFromFile();

        foreach ($tasks as &$task) {
            $taskModel = Task::fromArray($task);
            if ($taskModel->getId() == $taskId) {
                // loop properties to update
                foreach($updateProps as $key => $value) {
                    if(!isset($task[$key])) continue;
                    $task[$key] = $value;
                }
                break;
            }
        }

        // Save the task here (file, DB, JSON...)
        $this->saveDataTaskIntoFile($tasks);
    }

    public function delete(int $taskId)
    {
        $tasks = $this->getDataTaskFromFile();
        $updatedTasks = array_filter($tasks, function($task) use ($taskId) {
            return $task['id'] != $taskId;
        });

        // Save the task here (file, DB, JSON...)
        $this->saveDataTaskIntoFile($updatedTasks);
    }

    public function findByStatus(array $params)
    {
        $tasksData = $this->getDataTaskFromFile();
        $tasks = [];
        foreach ($tasksData as $taskData) {
            if(!empty($params)){
                $status = $params[0] ?? null;
                if ($taskData['status'] != $status) continue;
                $tasks[] = Task::fromArray($taskData);
            }else{
                $tasks[] = Task::fromArray($taskData);
            }
        }
        print_r($tasks);
    }
}