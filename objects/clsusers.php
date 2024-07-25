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

        $sel->execute([$this->username, $this->password]);
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
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE id = ?';
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->id]);
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

        return $upd->execute([$this->firstname, $this->lastname, $this->username, $this->password, $this->id]) ? true : false;
    }

    public function update_account_np()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET firstname = ?, lastname=?, username=? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        return $upd->execute([$this->firstname, $this->lastname, $this->username, $this->id]) ? true : false;
    }
}
