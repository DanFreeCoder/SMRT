<?php

class clsUsers
{

    protected $conn;
    private $tblname = 'users';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login()
    {
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE username = ? AND password = ? AND status != 0';
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->username);
        $sel->bindParam(2, $this->password);
        $sel->execute();
        return $sel;
    }

    public function users()
    {
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE status != 0 AND access_type = 2';
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }

    public function user_byid()
    {
        $sql = 'SELECT CONCAT(firstname, " ", lastname) as fullname FROM ' . $this->tblname . ' WHERE id = ?';
        $sel = $this->conn->prepare($sql);
        $sel->bindParam(1, $this->id);
        $sel->execute();
        return $sel;
    }
    public function logout()
    { //Author: Dan
        session_start();
        if (session_destroy()) {
            return true;
            unset($_SESSION['fullname']);
        } else {
            return false;
        }
    }

    public function update_account()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET firstname = ?, lastname=?, username=?, password=? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        $upd->bindParam(1, $this->firstname);
        $upd->bindParam(2, $this->lastname);
        $upd->bindParam(3, $this->username);
        $upd->bindParam(4, $this->password);
        $upd->bindParam(5, $this->id);

        return $upd->execute() ? true : false;
    }
    public function update_account_np()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET firstname = ?, lastname=?, username=? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        $upd->bindParam(1, $this->firstname);
        $upd->bindParam(2, $this->lastname);
        $upd->bindParam(3, $this->username);
        $upd->bindParam(4, $this->id);

        return $upd->execute() ? true : false;
    }
}
