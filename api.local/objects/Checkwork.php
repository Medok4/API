<?php

namespace objects;

class Checkwork
{
    // соединение с БД и таблицей "categories"
    private $conn;
    private $table_name = "checkwork";

    // свойства объекта
    public $check_id;
    public $employee_id;
    public $work_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function readAll(){
        $query = "SELECT
                *
            FROM
                 ".$this->table_name;
            

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;        
    }

    public function create(){
        $query="insert into ".$this->table_name." (check_id, employee_id, work_id) 
        values (:check_id,:employee_id,:work_id)";
        $stmt = $this->conn->prepare($query);
        $this->check_id=htmlspecialchars(strip_tags($this->check_id));
        $this->employee_id=htmlspecialchars(strip_tags($this->employee_id));
        $this->work_id=htmlspecialchars(strip_tags($this->work_id));
        $stmt->bindParam(':check_id',$this->check_id);
        $stmt->bindParam(':employee_id',$this->employee_id);
        $stmt->bindParam(':work_id',$this->work_id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function delete()
    {
        $query = "delete from ".$this->table_name." where check_id=:check_id";
        $stmt = $this->conn->prepare($query);
        $this->check_id = htmlspecialchars(strip_tags($this->check_id));
        $stmt->bindParam(':check_id',$this->check_id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function update()
    {
        $query = "update " . $this->table_name . " set check_id=:check_id,
                                                employee_id=:employee_id,
                                                work_id=:work_id";
        $stmt = $this->conn->prepare($query);
        $this->check_id = htmlspecialchars(strip_tags($this->check_id));
        $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));
        $this->work_id = htmlspecialchars(strip_tags($this->work_id));

        $stmt->bindParam(':check_id',$this->check_id);
        $stmt->bindParam(':employee_id',$this->employee_id);
        $stmt->bindParam(':work_id',$this->work_id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function  search($keyword)
    {
        $query="select category_number, money_for_hour
                from ".$this->table_name.  
                " where money_for_hour like ?";

        $stmt = $this->conn->prepare($query);
        $keyword=htmlspecialchars(strip_tags($keyword));
        $keyword="%$keyword%";
        $stmt->bindParam(1,$keyword);
        // $stmt->bindParam(2,$keyword);
        // $stmt->bindParam(3,$keyword);
        $stmt->execute();
        return $stmt;
    }
}