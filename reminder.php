<?php include_once 'partials/header.php'; ?>

<!-- Page content-->
<div class="main-container" style="margin-top: 80px; overflow-x:hidden;">
    <div class="container">
        <div class="card">
            <div class="clock" align="center">
                <h1 class="digital" style="font-size: 8em;"></h1>
                <h3 class="today"></h3>
                <br>
                <button class="btn btn-flat btn-success" id="setReminder" data-bs-toggle="modal" data-bs-target="#exampleModal">Set Reminder</button>
            </div>
        </div>
    </div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff;">
                            Scheduled
                        </div>
                        <div class="card-body" style="max-height:300px; height:300px; overflow-y:scroll;">
                            <ul class="list-group list-group-flush" id="reminder-list">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff;">
                            Recently used
                        </div>
                        <div class="card-body" style="max-height:300px; height:300px; overflow-y:scroll;">
                            <ul class="list-group list-group-flush" id="recent-list">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-light">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Set Reminder</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reminderForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="date">Date</label>
                                <input type="text" name="datepicker" id="datepicker" class="form-control" placeholder="mm/dd/yyyy" required>
                            </div>
                            <div class="col-6">
                                <label for="time">Time</label>
                                <input type="time" name="time" id="time" class="form-control mb-3">
                            </div>
                            <div class="col-12">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control mb-3" placeholder="Reminder" required>
                                <label for="notes">Notes</label>
                                <textarea name="notes" id="notes" class="form-control mb-3" placeholder="Write a note..."></textarea>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="repeat">
                                            <label class="form-check-label" style="margin-right: 10px; margin-left: 5px;"> Repeat</label>
                                            <div id="days">
                                                <button type="button" class="day" value="7" disabled>Su</button>
                                                <button type="button" class="day" value="1" disabled>M</button>
                                                <button type="button" class="day" value="2" disabled>Tu</button>
                                                <button type="button" class="day" value="3" disabled>We</button>
                                                <button type="button" class="day" value="4" disabled>Th</button>
                                                <button type="button" class="day" value="5" disabled>Fri</button>
                                                <button type="button" class="day" value="6" disabled>Sa</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <select name="repeat_type" id="repeat_type" class="form-control" disabled>
                                            <option value="8">Daily</option>
                                            <option value="9">Weekdays</option>
                                            <option value="10">Weekends</option>
                                            <option value="11">Weekly</option>
                                            <option value="12">Biweekly</option>
                                            <option value="13">Montly</option>
                                            <option value="14">Every 3 Months</option>
                                            <option value="15">Every 6 Months</option>
                                            <option value="16">Yearly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-flat btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-flat btn-success">Start</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- UPDATE MODAL -->
    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-light">
                    <h1 class="modal-title fs-5" id="titleHeader"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="Edit-reminderForm">
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-flat btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-flat btn-success">Set</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'partials/footer.php'; ?>
<script src="js/reminder.js"></script>

</body>

</html>