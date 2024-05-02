<?php
session_start();
class clsTask
{

    protected $conn;
    private $tblname = 'task';
    private $tblname2 = 'logs';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function store()
    {
        $sql = 'INSERT INTO ' . $this->tblname . ' SET user_id=?, task=?, timeline=?, urgency=?, add_comment=?, assigned_by=?, created_at=?, status=?';
        $ins = $this->conn->prepare($sql);

        $ins->bindParam(1, $this->user_id);
        $ins->bindParam(2, $this->task);
        $ins->bindParam(3, $this->timeline);
        $ins->bindParam(4, $this->urgency);
        $ins->bindParam(5, $this->add_comment);
        $ins->bindParam(6, $this->assigned_by);
        $ins->bindParam(7, $this->created_at);
        $ins->bindParam(8, $this->status);

        return $ins->execute() ? true : false;
    }

    public function task()
    {
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE status = ? AND assigned_by = ' . $_SESSION['id'] . ' ORDER BY id DESC';
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->status);
        $sel->execute();
        return $sel;
    }
    public function taskforUser()
    {
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE status = ? AND user_id = ' . $_SESSION['id'] . ' ORDER BY id DESC';
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->status);
        $sel->execute();
        return $sel;
    }

    public function all_task()
    {
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE status != 0 AND assigned_by = ' . $_SESSION['id'] . ' ORDER BY id DESC';
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }
    public function all_taskforUser()
    {

        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE status != 0 AND user_id = ' . $_SESSION['id'] . ' ORDER BY id DESC';
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }

    public function update_task()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET status = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        $upd->bindParam(1, $this->status);
        $upd->bindParam(2, $this->id);

        return $upd->execute() ? true : false;
    }

    public function store_logs()
    {
        $sql = 'INSERT INTO ' . $this->tblname2 . ' SET task_id=?, days=?, name=?, context=?, status=?, date_logs =?';
        $ins = $this->conn->prepare($sql);

        $ins->bindParam(1, $this->task_id);
        $ins->bindParam(2, $this->days);
        $ins->bindParam(3, $this->name);
        $ins->bindParam(4, $this->context);
        $ins->bindParam(5, $this->status);
        $ins->bindParam(6, $this->date_logs);

        return $ins->execute() ? true : false;
    }

    public function last_logs()
    {
        $sql = 'SELECT `date_logs` as last_logs FROM ' . $this->tblname2 . ' ORDER BY id DESC LIMIT 1';
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }

    public function logs()
    {
        $sql = 'SELECT * FROM ' . $this->tblname2 . ' WHERE task_id = ? AND status != 0 ORDER BY id DESC';
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->task_id);
        $sel->execute();
        return $sel;
    }

    public function task_details()
    {
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE id = ?';
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->id);
        $sel->execute();
        return $sel;
    }

    public function get_date_logs()
    {
        $sql = 'SELECT date_logs FROM ' . $this->tblname2 . ' WHERE id = ?';
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->id);
        $sel->execute();
        return $sel;
    }

    public function upd_date_logs()
    {
        $sql = 'UPDATE ' . $this->tblname2 . ' SET date_logs = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        $upd->bindParam(1, $this->date_logs);
        $upd->bindParam(2, $this->id);

        return $upd->execute() ? true : false;
    }

    public function update_urgency()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET urgency = ? WHERE id=?';
        $upd = $this->conn->prepare($sql);

        $upd->bindParam(1, $this->urgency);
        $upd->bindParam(2, $this->id);

        return $upd->execute() ? true : false;
    }
}
