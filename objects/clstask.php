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

        $ex = $ins->execute([$this->user_id, $this->task, $this->timeline, $this->urgency, $this->add_comment, $this->assigned_by, $this->created_at, $this->status]);

        return $ex ? true : false;
    }

    public function task()
    {
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE status != 0  ORDER BY created_at DESC';
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }
    public function taskforUser()
    {
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE status = ? AND FIND_IN_SET(' . $_SESSION['id'] . ', user_id)  ORDER BY id DESC';
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->status]);
        return $sel;
    }

    public function task_filter_by()
    {
        $sql = 'SELECT * FROM ' . $this->tblname . ' WHERE status != 0 AND FIND_IN_SET(?, user_id) ORDER BY id DESC';
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->user_id]);
        return $sel;
    }
    public function update_task()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET status = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        return $upd->execute([$this->status, $this->id]) ? true : false;
    }

    public function mark_done()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET date_done = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        return $upd->execute([$this->date_done, $this->id]) ? true : false;
    }

    public function mark_close()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET date_close = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        return $upd->execute([$this->date_close, $this->id]) ? true : false;
    }
    public function store_logs()
    {
        $sql = 'INSERT INTO ' . $this->tblname2 . ' SET task_id=?, name=?, context=?, status=?, date_logs =?';
        $ins = $this->conn->prepare($sql);

        $ex = $ins->execute([$this->task_id, $this->name, $this->context, $this->status, $this->date_logs]);

        return $ex ? true : false;
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

        $sel->execute([$this->task_id]);
        return $sel;
    }
    public function first_logs_byid()
    {
        $sql = 'SELECT `date_logs` as first_logs FROM ' . $this->tblname2 . ' WHERE task_id = ? ORDER BY id ASC LIMIT 1';
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->task_id]);
        return $sel;
    }

    public function get_date_createdTask()
    {
        $sql = 'SELECT created_at FROM ' . $this->tblname . ' WHERE id = ?';
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->id]);
        return $sel;
    }

    public function upd_date_createdTask()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET created_at = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        return $upd->execute([$this->created_at, $this->id]) ? true : false;
    }

    public function logs()
    {
        $sql = 'SELECT * FROM ' . $this->tblname2 . ' WHERE task_id = ? AND status != 0 ORDER BY id DESC';
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->task_id]);
        return $sel;
    }

    public function task_details()
    {
        $sql = 'SELECT t.id, t.task, t.timeline, t.extend_due, t.urgency, t.created_at, t.add_comment, CONCAT(u.firstname, " ", u.lastname) as assigned_by, t.status, t.user_id as assignee FROM task t JOIN users u ON u.id = t.assigned_by WHERE t.id = ?';
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->id]);
        return $sel;
    }

    public function get_date_logs()
    {
        $sql = 'SELECT date_logs, context FROM ' . $this->tblname2 . ' WHERE id = ?';
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->id]);
        return $sel;
    }
    public function get_prev_date_logs()
    {
        $sql = 'SELECT date_logs as date_logs_prev FROM ' . $this->tblname2 . ' WHERE id = ? - 1';
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->id]);
        return $sel;
    }
    public function delete_task()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET status = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        return $upd->execute([$this->status, $this->id]) ? true : false;
    }

    public function upd_date_logs()
    {
        $sql = 'UPDATE ' . $this->tblname2 . ' SET date_logs = ?, context = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        $exParam = $upd->execute([$this->date_logs, $this->context, $this->id]);
        return $exParam ? true : false;
    }

    public function update_urgency()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET urgency = ? WHERE id=?';
        $upd = $this->conn->prepare($sql);

        return $upd->execute([$this->urgency, $this->id]) ? true : false;
    }

    public function upd_task_user_id()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET user_id = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        return $upd->execute([$this->user_id, $this->id]) ? true : false;
    }

    public function automatic_email_to_assigner()
    {
        $sql = 'SELECT t.timeline, t.extend_due, t.task, t.add_comment, CONCAT(u.firstname, " ", u.lastname) as fullname, u.email FROM task t JOIN users u ON u.id = t.assigned_by WHERE t.status = 1';
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }
    public function automatic_email_to_handler()
    {
        $sql = 'SELECT t.timeline, t.extend_due, t.task, t.add_comment, t.user_id, CONCAT(u.firstname, " ", u.lastname) as fullname, u.email FROM task t JOIN users u ON u.id = t.user_id WHERE t.status = 1';
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }

    public function assignee_byid()
    {
        $sql = "SELECT user_id as ids FROM $this->tblname WHERE id = ?";
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->id]);
        return $sel;
    }

    public function lastAddTask()
    {
        $sql = "SELECT id as lastTaskId FROM $this->tblname WHERE assigned_by = " . $_SESSION['id'] . " ORDER BY id DESC LIMIT 1";
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }

    public function assignerid_byTask()
    {
        $sql = 'SELECT assigned_by as assigner FROM ' . $this->tblname . ' WHERE id = ?';
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->id]);
        return $sel;
    }

    public function check_to_reassign()
    {
        $sql = 'SELECT user_id FROM ' . $this->tblname . ' WHERE id = ?';
        $sel = $this->conn->prepare($sql);

        $sel->execute([$this->id]);
        return $sel;
    }

    public function extend_due()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET extend_due = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        return $upd->execute([$this->extend_due, $this->id]) ? true : false;
    }
}
