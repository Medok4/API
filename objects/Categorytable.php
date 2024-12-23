<?php

namespace objects;

class Categorytable
{
    // соединение с БД и таблицей "categories"
    private $conn;
    private $table_name = "categorytable";

    // свойства объекта
    public $category_number;
    public $money_for_hour;

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
        $query="insert into ".$this->table_name." (category_number, money_for_hour) 
        values (:category_number,:money_for_hour)";
        $stmt = $this->conn->prepare($query);
        $this->category_number=htmlspecialchars(strip_tags($this->category_number));
        $this->money_for_hour=htmlspecialchars(strip_tags($this->money_for_hour));
        $stmt->bindParam(':category_number',$this->category_number);
        $stmt->bindParam(':money_for_hour',$this->money_for_hour);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function delete()
    {
        $query = "delete from ".$this->table_name." where category_number=:category_number";
        $stmt = $this->conn->prepare($query);
        $this->category_number = htmlspecialchars(strip_tags($this->category_number));
        $stmt->bindParam(':category_number',$this->category_number  );
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function update()
    {
        $query = "update " . $this->table_name . " set category_number=:category_number,
                                                money_for_hour=:money_for_hour";
        $stmt = $this->conn->prepare($query);
        $this->category_number = htmlspecialchars(strip_tags($this->category_number));
        $this->money_for_hour = htmlspecialchars(strip_tags($this->money_for_hour));

        $stmt->bindParam(':category_number',$this->category_number);
        $stmt->bindParam(':money_for_hour',$this->money_for_hour);
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