<?php

class DB extends mysqli {

    public function __construct() {
        $objCon = $this->connect("localhost", "dbuser", "dbpw", "db");
        
        $this->objCon = $objCon;
        $this->set_charset("utf8");
        
        if ($this->connect_errno) {
            die('can not connect (' . $this->connect_errno . ')' . $this->connect_error);
        }
        
        // echo 'connected succesfully';
    }

//sletter fra databasen
    public function delete($table_name, $where) {
//DELETES FROM $table_name WHERE $where returns 1 for true 0 for false
        $sql = "DELETE FROM " . $table_name . " WHERE " . $where;

        if ($this->query($sql)) {
            return true;
        }
        return false;
    }

// indsætter i databasen 
    public function create($table_name, $data) {
        $cols = array_keys($data);
        $split_cols = implode(",", $cols);
        $split_data = implode("','", $data);

        $sql = "INSERT INTO " . $table_name . " (" . $split_cols . ") VALUES ('" . $split_data . "')";
        if ($this->query($sql)) {
            return $this->insert_id;
        }
        return false;
    }

// opdaterer i databasen
    public function update($table_name, $data, $where) {
//UPDATES $table_name SETS $data WHERE $where returns 1 for true 0 for false
        $sql = "UPDATE " . $table_name . " SET ";

        $sets = [];
        foreach ($data as $key => $value) {
            $sets[] = $key . "='" . $this->real_escape_string($value) . "'";
        }

        $sql .= implode(', ', $sets);

        if ($where != '0') {
            $sql .= ' WHERE ' . $where;
        }

        if ($this->query($sql)) {
            return true;
        }
        return false;
    }

// vælger fra databasen    
    public function read($table_name, $cols, $where = NULL, $limit = NULL) {
        //GET $cols FROM $table_name WHERE $where returns 0 for false and fetch_object() for true
        $query = "SELECT " . $cols . " FROM " . $table_name;

        if ($where) {
            $query .= " WHERE " . $where;
        }

        if ($limit) {
            $query .= " " . $limit;
        }

        //echo $query;

        $sql = $this->query($query);

        if ($sql) {
            $data = array();
            $data['count'] = $sql->num_rows;
            while ($row = $sql->fetch_object()) {
                $data['results'][] = $row;
            }
            return $data;
        }
        return false;
    }

}
