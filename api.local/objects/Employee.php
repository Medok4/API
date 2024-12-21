<?php

namespace objects;

class Employee
{
    // соединение с БД и таблицей "categories"
    private $conn;
    private $table_name = "employee";

    // свойства объекта
    public $employee_id;
    public $employee_name;
    public $last_name;
    public $middle_name;
    public $birth_date;
    public $work_phone_number;
    public $passport_number;
    public $category_number;

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
        $query="insert into ".$this->table_name." (employee_id, employee_name, last_name, middle_name, birth_date, work_phone_number, passport_number, category_number) 
        values (:employee_id,:employee_name,:last_name,:middle_name,:birth_date,:work_phone_number,:passport_number,:category_number)";
        $stmt = $this->conn->prepare($query);
        $this->employee_id=htmlspecialchars(strip_tags($this->employee_id));
        $this->employee_name=htmlspecialchars(strip_tags($this->employee_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->middle_name=htmlspecialchars(strip_tags($this->middle_name));
        $this->birth_date=htmlspecialchars(strip_tags($this->birth_date));
        $this->work_phone_number=htmlspecialchars(strip_tags($this->work_phone_number));
        $this->passport_number=htmlspecialchars(strip_tags($this->passport_number));
        $this->category_number=htmlspecialchars(strip_tags($this->category_number));
        $stmt->bindParam(':employee_id',$this->employee_id);
        $stmt->bindParam(':employee_name',$this->employee_name);
        $stmt->bindParam(':last_name',$this->last_name);
        $stmt->bindParam(':middle_name',$this->middle_name);
        $stmt->bindParam(':birth_date',$this->birth_date);
        $stmt->bindParam(':work_phone_number',$this->work_phone_number);
        $stmt->bindParam(':passport_number',$this->passport_number);
        $stmt->bindParam(':category_number',$this->category_number);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function delete()
    {
        $query = "delete from ".$this->table_name." where employee_id=:employee_id";
        $stmt = $this->conn->prepare($query);
        $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));
        $stmt->bindParam(':employee_id',$this->employee_id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function update()
    {
        $query = "update " . $this->table_name ." set employee_id=:employee_id,
                                                employee_name=:employee_name,
                                                last_name=:last_name,
                                                middle_name=:middle_name,
                                                birth_date=:birth_date,
                                                work_phone_number=:work_phone_number,
                                                passport_number=:passport_number,
                                                category_number=:category_number";
        $stmt = $this->conn->prepare($query);
        $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));
        $this->employee_name = htmlspecialchars(strip_tags($this->employee_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->middle_name = htmlspecialchars(strip_tags($this->middle_name));
        $this->birth_date = htmlspecialchars(strip_tags($this->birth_date));
        $this->work_phone_number = htmlspecialchars(strip_tags($this->work_phone_number));
        $this->passport_number = htmlspecialchars(strip_tags($this->passport_number));
        $this->category_number = htmlspecialchars(strip_tags($this->category_number));

        $stmt->bindParam(':employee_id',$this->employee_id);
        $stmt->bindParam(':employee_name',$this->employee_name);
        $stmt->bindParam(':last_name',$this->last_name);
        $stmt->bindParam(':middle_name',$this->middle_name);
        $stmt->bindParam(':birth_date',$this->birth_date);
        $stmt->bindParam(':work_phone_number',$this->work_phone_number);
        $stmt->bindParam(':passport_number',$this->passport_number);
        $stmt->bindParam(':category_number',$this->category_number);
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