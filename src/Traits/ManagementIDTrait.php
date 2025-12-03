<?php

    namespace App\Traits;

    trait ManagementIDTrait {
        private $path = __DIR__ . '/../../data/id_counter.json';

        public function generateId() {
            $lastId = $this->readLastId();
            $newId = $lastId + 1;

            $data = ['last_id' => $newId];
            file_put_contents($this->path, json_encode($data));

            return $newId;
        }

        private function readLastId()
        {
            if(file_exists($this->path) === false) {
                //make new file
                $data = ['last_id' => 0];
                file_put_contents($this->path, json_encode($data));
            }else{
                $str = file_get_contents($this->path);
                $data = json_decode($str, true);
            }

            return $data['last_id'] ?? 0;
        }
    }