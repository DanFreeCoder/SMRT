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

        $exeParam =  $ins->execute([$this->date, $this->next_date, $this->time, $this->title, $this->notes, $this->day_repeat, $this->is_repeat, $this->status, $this->user_id]);
        return $exeParam ? true : false;
    }

    public function update_reminder()
    {
        $sql = "UPDATE $this->tblname SET `date` =?, `time`= ?, title = ?, notes = ?, day_repeat = ?, is_repeat = ?, status = ? WHERE id = ?";
        $upd = $this->conn->prepare($sql);

        $exeParam = $upd->execute([$this->date, $this->time, $this->title, $this->notes, $this->day_repeat, $this->is_repeat, $this->status, $this->id]);
        return $exeParam ? true : false;
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

        $sel->execute([$this->id]);
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

        return $upd->execute([$this->status, $this->id]) ? true : false;
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

        return $upd->execute([$this->next_date, $this->id]) ? true : false;
    }
}
