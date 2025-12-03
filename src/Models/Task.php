<?php 
    namespace App\Models;
    use App\Enum\Task\Status;

    class Task {
        private $id;
        private $description;
        private Status $status;
        private $createdAt;
        private $updatedAt;
        
        public function __construct($id, $description, Status $status, $createdAt, $updatedAt) {
            // Constructor code here
            $this->id = $id;
            $this->description = $description;
            $this->status = $status;
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
        }

        public function getId() {
            return $this->id;
        }

        public function getDescription() {
            return $this->description;
        }

        public function getStatus(): Status {
            return $this->status;
        }

        public function getCreatedAt() {
            return $this->createdAt;
        }

        public function getUpdatedAt() {
            return $this->updatedAt;
        }

        public function setDescription($description) {
            $this->description = $description;
        }

        public static function fromArray(array $data): Task {
            return new Task(
                $data['id'],
                $data['description'],
                Status::tryFrom($data['status']),
                $data['created_at'],
                $data['updated_at']
            );
        }

        public static function fromObject(Task $task): array {

            return [
                'id' => $task->getId(),
                'description' => $task->getDescription(),
                'status' => $task->getStatus()->value,
                'created_at' => $task->getCreatedAt(),
                'updated_at' => $task->getUpdatedAt(),
            ];
        }
    }
?>