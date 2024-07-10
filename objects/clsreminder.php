<?php
class clsreminder
{

    protected $conn;
    private $tblname = 'reminder';

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function save_reminder()
    {
        $sql = "INSERT INTO $this->tblname SET `date` = ?, next_date = ?, `time` = ?, title = ?, notes = ?, day_repeat = ?, is_repeat = ?, status = ?, user_id = ?";
        $ins = $this->conn->prepare($sql);

        $ins->bindParam(1, $this->date);
        $ins->bindParam(2, $this->next_date);
        $ins->bindParam(3, $this->time);
        $ins->bindParam(4, $this->title);
        $ins->bindParam(5, $this->notes);
        $ins->bindParam(6, $this->day_repeat);
        $ins->bindParam(7, $this->is_repeat);
        $ins->bindParam(8, $this->status);
        $ins->bindParam(9, $this->user_id);

        return  $ins->execute() ? 1 : 0;
    }

    public function update_reminder()
    {
        $sql = "UPDATE $this->tblname SET `date` =?, `time`= ?, title = ?, notes = ?, day_repeat = ?, is_repeat = ?, status = ? WHERE id = ?";
        $upd = $this->conn->prepare($sql);

        $upd->bindParam(1, $this->date);
        $upd->bindParam(2, $this->time);
        $upd->bindParam(3, $this->title);
        $upd->bindParam(4, $this->notes);
        $upd->bindParam(5, $this->day_repeat);
        $upd->bindParam(6, $this->is_repeat);
        $upd->bindParam(7, $this->status);
        $upd->bindParam(8, $this->id);

        return $upd->execute() ? true : false;
    }



    public function reminders()
    {
        $sql = "SELECT reminder.id, reminder.user_id, reminder.date, reminder.time, reminder.title, reminder.notes, reminder.day_repeat, reminder.is_repeat, CONCAT(users.firstname,' ', users.lastname) as fullname FROM $this->tblname, users WHERE reminder.status = 2 AND users.id = reminder.user_id AND reminder.user_id = " . $_SESSION['id'] . " ORDER BY reminder.id DESC";
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }

    public function reminder_byid()
    {
        $sql = "SELECT * FROM $this->tblname WHERE id = ?";
        $sel = $this->conn->prepare($sql);

        $sel->bindParam(1, $this->id);
        $sel->execute();
        return $sel;
    }

    public function recent_used()
    {
        $sql = "SELECT reminder.id, reminder.user_id, reminder.date, reminder.time, reminder.title, reminder.notes, reminder.day_repeat, reminder.is_repeat, CONCAT(users.firstname,' ', users.lastname) as fullname FROM $this->tblname, users WHERE reminder.status = 1 AND users.id = reminder.user_id AND reminder.user_id = " . $_SESSION['id'] . " ORDER BY reminder.id DESC";
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }

    public function remove()
    {
        $sql = "UPDATE $this->tblname SET status = ? WHERE id = ?";
        $upd = $this->conn->prepare($sql);

        $upd->bindParam(1, $this->status);
        $upd->bindParam(2, $this->id);

        $upd->execute();
        return $upd ? true : false;
    }

    public function cron_reminders()
    {
        $sql = "SELECT r.id, r.user_id, r.date, r.next_date, r.time, r.title, r.notes, r.day_repeat, r.is_repeat, CONCAT(u.firstname, ' ',u.lastname) as fullname, u.email FROM $this->tblname r JOIN users u ON u.id = r.user_id WHERE r.status != 0 AND r.status = 2";
        $sel = $this->conn->prepare($sql);

        $sel->execute();
        return $sel;
    }

    function update_next_date()
    {
        $sql = 'UPDATE ' . $this->tblname . ' SET next_date = ? WHERE id = ?';
        $upd = $this->conn->prepare($sql);

        $upd->bindParam(1, $this->next_date);
        $upd->bindParam(2, $this->id);

        return $upd->execute() ? true : false;
    }
}
