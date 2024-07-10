<?php
include '../config/connection.php';
include '../objects/clsreminder.php';
$database = new clsConnection();
$db = $database->connect();

$reminder = new clsreminder($db);

$reminder->id = $_POST['id'];
$task = $reminder->reminder_byid();
while ($row = $task->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $days = explode(',', $day_repeat);
    echo '
        <div class="row">
            <div class="col-6">
                <label for="date">Date</label>
                <input type="text" name="id" value="' . $id . '" hidden/>
                <input type="text" name="datepicker" id="datepicker2" value="' . date('m/d/Y', strtotime($date)) . '" class="form-control" placeholder="mm/dd/yyyy" required>
            </div>
            <div class="col-6">
                <label for="time">Time</label>
                <input type="time" name="time" id="time" value="' . $time . '" class="form-control mb-3">
            </div>
            <div class="col-12">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control mb-3" value="' . $title . '" placeholder="Reminder" required>
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" class="form-control mb-3" placeholder="Write a note...">' . $notes . '</textarea>
                <div class="row">
                    <div class="col-6">
                    <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="repeat" ' . ($is_repeat > 0 ? 'checked' : '') . '>
                            <label class="form-check-label" for="repeat" style="margin-right: 10px; margin-left: 5px;"> Repeat</label>
                            <div id="days">
                                <button type="button" class="day ' . (in_array(7, $days) ? 'dayClicked' : '') . '" value="7" style="' . (in_array(7, $days) ? 'background-color:#00a8ff; border:1px solid #00a8ff; color:#fff;' : '') . '" ' . ($is_repeat > 0 ? '' : 'disabled') . '>Su</button>
                                <button type="button" class="day ' . (in_array(1, $days) ? 'dayClicked' : '') . '" value="1" style="' . (in_array(1, $days) ? 'background-color:#00a8ff; border:1px solid #00a8ff; color:#fff;' : '') . '" ' . ($is_repeat > 0 ? '' : 'disabled') . '>M</button>
                                <button type="button" class="day ' . (in_array(2, $days) ? 'dayClicked' : '') . '" value="2" style="' . (in_array(2, $days) ? 'background-color:#00a8ff; border:1px solid #00a8ff; color:#fff;' : '') . '" ' . ($is_repeat > 0 ? '' : 'disabled') . '>Tu</button>
                                <button type="button" class="day ' . (in_array(3, $days) ? 'dayClicked' : '') . '" value="3" style="' . (in_array(3, $days) ? 'background-color:#00a8ff; border:1px solid #00a8ff; color:#fff;' : '') . '" ' . ($is_repeat > 0 ? '' : 'disabled') . '>We</button>
                                <button type="button" class="day ' . (in_array(4, $days) ? 'dayClicked' : '') . '" value="4" style="' . (in_array(4, $days) ? 'background-color:#00a8ff; border:1px solid #00a8ff; color:#fff;' : '') . '" ' . ($is_repeat > 0 ? '' : 'disabled') . '>Th</button>
                                <button type="button" class="day ' . (in_array(5, $days) ? 'dayClicked' : '') . '" value="5" style="' . (in_array(5, $days) ? 'background-color:#00a8ff; border:1px solid #00a8ff; color:#fff;' : '') . '" ' . ($is_repeat > 0 ? '' : 'disabled') . '>Fri</button>
                                <button type="button" class="day ' . (in_array(6, $days) ? 'dayClicked' : '') . '" value="6" style="' . (in_array(6, $days) ? 'background-color:#00a8ff; border:1px solid #00a8ff; color:#fff;' : '') . '" ' . ($is_repeat > 0 ? '' : 'disabled') . '>Sa</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <select name="upd_repeat_type" id="upd_repeat_type" class="form-control" ' . ($is_repeat > 0 ? '' : 'disabled') . '>
                            <option value="8" ' . (in_array(8, $days) ? 'selected' : '') . '>Daily</option>
                            <option value="9" ' . (in_array(9, $days) ? 'selected' : '') . '>Weekdays</option>
                            <option value="10" ' . (in_array(10, $days) ? 'selected' : '') . '>Weekends</option>
                            <option value="11" ' . (in_array(11, $days) ? 'selected' : '') . '>Weekly</option>
                            <option value="12" ' . (in_array(12, $days) ? 'selected' : '') . '>Biweekly</option>
                            <option value="13" ' . (in_array(13, $days) ? 'selected' : '') . '>Montly</option>
                            <option value="14" ' . (in_array(14, $days) ? 'selected' : '') . '>Every 3 Months</option>
                            <option value="15" ' . (in_array(15, $days) ? 'selected' : '') . '>Every 6 Months</option>
                            <option value="16" ' . (in_array(16, $days) ? 'selected' : '') . '>Yearly</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
     
    ';
}
