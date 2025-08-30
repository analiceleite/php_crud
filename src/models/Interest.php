<?php
class Interest
{
    public $interest_id;
    public $name;
    
    public function __construct($data)
    {
        $this->interest_id = $data['interest_id'] ?? null;
        $this->name = trim($data['name']) ?? '';
    }
}