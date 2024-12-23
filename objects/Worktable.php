<?php

namespace objects;

class Worktable
{
    // соединение с БД и таблицей "categories"
    private $conn;
    private $table_name = "worktable";

    // свойства объекта
    public $work_id;
    public $company_name;
    public $work_date;
    public $hours_spend;

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
        $query="insert into ".$this->table_name." (work_id, company_name, work_date, hours_spend) 
        values (:work_id,:company_name,:work_date,:hours_spend)";
        $stmt = $this->conn->prepare($query);
        $this->work_id=htmlspecialchars(strip_tags($this->work_id));
        $this->company_name=htmlspecialchars(strip_tags($this->company_name));
        $this->work_date=htmlspecialchars(strip_tags($this->work_date));
        $this->hours_spend=htmlspecialchars(strip_tags($this->hours_spend));
        $stmt->bindParam(':work_id',$this->work_id);
        $stmt->bindParam(':company_name',$this->company_name);
        $stmt->bindParam(':work_date',$this->work_date);
        $stmt->bindParam(':hours_spend',$this->hours_spend);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function delete()
    {
        $query = "delete from ".$this->table_name." where work_id=:work_id";
        $stmt = $this->conn->prepare($query);
        $this->work_id = htmlspecialchars(strip_tags($this->work_id));
        $stmt->bindParam(':work_id',$this->work_id  );
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function update()
    {
        $query = "update " . $this->table_name . " set work_id=:work_id,
                                                company_name=:company_name,
                                                work_date=:work_date,
                                                hours_spend=:hours_spend";
        $stmt = $this->conn->prepare($query);
        $this->work_id = htmlspecialchars(strip_tags($this->work_id));
        $this->company_name = htmlspecialchars(strip_tags($this->company_name));
        $this->work_date = htmlspecialchars(strip_tags($this->work_date));
        $this->hours_spend = htmlspecialchars(strip_tags($this->hours_spend));

        $stmt->bindParam(':work_id',$this->work_id);
        $stmt->bindParam(':company_name',$this->company_name);
        $stmt->bindParam(':work_date',$this->work_date);
        $stmt->bindParam(':hours_spend',$this->hours_spend);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function  search($keyword)
    {
        $query="select * from ".$this->table_name.  
                " where work_id = ?";

        $stmt = $this->conn->prepare($query);
        $keyword=htmlspecialchars(strip_tags($keyword));
        $keyword="$keyword";
        $stmt->bindParam(1,$keyword);
        // $stmt->bindParam(2,$keyword);
        // $stmt->bindParam(3,$keyword);
        $stmt->execute();
        return $stmt;
    }
}