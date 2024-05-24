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
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE status != 0 AND assigned_by = ' . $_SESSION['id'] . ' ORDER BY id DESC';
        $sel = $this->conn->prepare($sql);

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
    public function task_filter_by()
    {
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE status != 0 AND assigned_by = ' . $_SESSION['id'] . ' AND user_id = ? ORDER BY id DESC';
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->user_id);

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
        $sql = 'INSERT INTO ' . $this->tblname2 . ' SET task_id=?, name=?, context=?, status=?, date_logs =?';
        $ins = $this->conn->prepare($sql);

        $ins->bindParam(1, $this->task_id);
        $ins->bindParam(2, $this->name);
        $ins->bindParam(3, $this->context);
        $ins->bindParam(4, $this->status);
        $ins->bindParam(5, $this->date_logs);

        return $ins->execute() ? true : false;
    }

    public function last_logs()
    {
        $sql = 'SELECT `date_logs` as last_logs FROM ' . $this->tblname2 . ' ORDER BY id DESC LIMIT 1';
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }
    public function last_logs_byid()
    {
        $sql = 'SELECT `date_logs` as last_logs FROM ' . $this->tblname2 . ' WHERE task_id = ? ORDER BY id DESC LIMIT 1';
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->task_id);
        $sel->execute();
        return $sel;
    }
    public function first_logs_byid()
    {
        $sql = 'SELECT `date_logs` as first_logs FROM ' . $this->tblname2 . ' WHERE task_id = ? ORDER BY id ASC LIMIT 1';
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->task_id);
        $sel->execute();
        return $sel;
    }

    public function get_date_createdTask()
    {
        $sql = 'SELECT created_at FROM ' . $this->tblname . ' WHERE id = ?';
        $sel = $this->conn->prepare($sql);
        $sel->bindParam(1, $this->id);
        $sel->execute();
        return $sel;
    }

    public function upd_date_createdTask()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET created_at = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);
        $upd->bindParam(1, $this->created_at);
        $upd->bindParam(2, $this->id);

        return $upd->execute() ? true : false;
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
    public function get_prev_date_logs()
    {
        $sql = 'SELECT date_logs as date_logs_prev FROM ' . $this->tblname2 . ' WHERE id = ? - 1';
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->id);
        $sel->execute();
        return $sel;
    }
    public function delete_task()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET status = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        $upd->bindParam(1, $this->status);
        $upd->bindParam(2, $this->id);

        return $upd->execute() ? true : false;
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

    public function get_user_id()
    {
        $sql = 'SELECT user_id FROM ' . $this->tblname . ' WHERE id = ?';
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->id);
        $sel->execute();
        return $sel;
    }

    public function upd_task_user_id()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET user_id = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        $upd->bindParam(1, $this->user_id);
        $upd->bindParam(2, $this->id);

        return $upd->execute() ? true : false;
    }

    public function automatic_email_to_assigner()
    {
        $sql = 'SELECT t.timeline, t.task, t.add_comment, CONCAT(u.firstname, " ", u.lastname) as fullname, u.email FROM task t JOIN users u ON u.id = t.assigned_by';
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }
    public function automatic_email_to_handler()
    {
        $sql = 'SELECT t.timeline, t.task, t.add_comment, CONCAT(u.firstname, " ", u.lastname) as fullname, u.email FROM task t JOIN users u ON u.id = t.user_id';
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }
}
