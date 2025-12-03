<?php
    namespace App\Commands;

    use App\Commands\Command;
use App\Enum\Task\Status;
use App\Service\TaskService;
    use Exception;

    class TaskCommand implements Command
    {
        private TaskService $taksService;

        public function __construct(TaskService $taksService)
        {
            $this->taksService = $taksService;
        }

        public function run(array $args)
        {
            list($action, $params) = $args;

            switch($action){
                case 'add':
                    $this->handleAdd($params);
                    break;
                case 'update':
                    $this->handleUpdate($params);
                    break;    
                case 'delete':
                    $this->handleDelete($params);
                    break;        
                case 'mark-in-progress':
                    $this->handleMarkStatusInProgress($params);
                    break;   
                case 'mark-done':
                    $this->handleMarkStatusDone($params);
                    break; 
                case 'list':
                    $this->taksService->findByStatus($params);
                    break;                        
                default: 
                    echo "Unknown action: $action\n";
                    break;    
            }
        }

        public function handleAdd(array $params)
        {
            $taskName = $params[0] ?? null;
            
            if (!$taskName) {
                echo "Usage: task-cli add \"Task name\"\n";
                return;
            }
            $task = $this->taksService->add($taskName);
            // save the task here (file, DB, JSON...)
            echo "Task added successfully (ID: {$task->getId()})\n";   
        }

        public function handleUpdate(array $params)
        {
            try{
                $taskId = $params[0] ?? null;
                $taskDescription = $params[1] ?? null;
                
                if (!$taskId) {
                    echo "Usage: task-cli update \"Task Id\"\n";
                    return;
                }
                $this->taksService->save($taskId, array('description' => $taskDescription));
                // save the task here (file, DB, JSON...)
                echo "Task updated successfully (ID: {$taskId})\n";   
            }catch(Exception) {
                echo "Failed to update task data.\n";
            }
        }

        public function handleDelete(array $params)
        {
            try{
                $taskId = $params[0] ?? null;
            
                if (!$taskId) {
                    echo "Usage: task-cli delete \"Task Id\"\n";
                    return;
                }
                
                $this->taksService->delete($taskId);
                echo "Task deleted successfully (ID: {$taskId})\n";
            }catch(Exception) {
                echo "Failed to delete task.\n";
            }
        }

        public function handleMarkStatusInProgress(array $params)
        {
            try{
                $taskId = $params[0] ?? null;
                
                if (!$taskId) {
                    echo "Usage: task-cli mark-in-progress \"Task Id\"\n";
                    return;
                }
                $this->taksService->save($taskId, array('status' => Status::InProgress->value));
                // save the task here (file, DB, JSON...)
                echo "Task updated to mark-status-in-progress successfully (ID: {$taskId})\n";   
            }catch(Exception) {
                echo "Failed to mark-status-in-progress task.\n";
            }
        }


        public function handleMarkStatusDone(array $params)
        {
            try{
                $taskId = $params[0] ?? null;
                
                if (!$taskId) {
                    echo "Usage: task-cli mark-done \"Task Id\"\n";
                    return;
                }
                $this->taksService->save($taskId, array('status' => Status::Done->value));
                // save the task here (file, DB, JSON...)
                echo "Task updated to mark-status-done successfully (ID: {$taskId})\n";   
            }catch(Exception) {
                echo "Failed to mark-status-done task.\n";
            }
        }
    }
?>
