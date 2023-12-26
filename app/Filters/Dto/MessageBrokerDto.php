<?php
namespace App\Filters\Dto;
class MessageBrokerDto {
    public $status;

    function __construct($status){
        $this->status = $status;
    }

    function getStatus(){
        return $this->status;
    }
}