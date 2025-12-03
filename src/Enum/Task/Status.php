<?php
    namespace App\Enum\Task;
    
    enum Status: string {
        case Todo = 'todo';
        case Done = 'done';
        case InProgress = 'in-progress';
    }
?>