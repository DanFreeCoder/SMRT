$(document).ready(function () {
    $('.modal #datepicker').datepicker({
        minDate: 0 //minimum date set today
    });
    //update time every seconds
    window.setInterval(ut, 1000)

    // REMINDERS
    getReminders().then((reminder) => {
        $('#reminder-list').html(reminder);
    })
    //RECENTLY USED
    getRecentUsed().then((reminder) => {
        $('#recent-list').html(reminder);
    })


    function getReminders() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'post',
                url: 'controller/reminders.php',
                success: function (html) {
                    resolve(html)
                },
                error: function (err) {
                    reject(err)
                }
            })
        });
    }

    function getRecentUsed() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'post',
                url: 'controller/recent_used.php',
                success: function (html) {
                    resolve(html)
                },
                error: function (err) {
                    reject(err)
                }
            })
        });
    }

    // REMOVE
    $(document).on('click', '.remove', function (e) {
        e.preventDefault();
        const id = $(this).attr('value');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, remove it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: 'controller/remove_reminder.php',
                    data: { id: id },
                    success: function (res) {
                        if (res > 0) {
                            getReminders().then((reminder) => {
                                $('#reminder-list').html(reminder);
                            });
                            getRecentUsed().then((reminder) => {
                                $('#recent-list').html(reminder);
                            })
                            Swal.fire({
                                title: "Removed!",
                                text: "Task reminder has been removed.",
                                icon: "success"
                            });
                        }
                    }
                })
            }
        });
    })
    // DELETE PERMANENTLY
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        const id = $(this).attr('value');
        Swal.fire({
            title: "Are you sure?",
            text: "This will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: 'controller/delete_reminder.php',
                    data: { id: id },
                    success: function (res) {
                        if (res > 0) {
                            getRecentUsed().then((reminder) => {
                                $('#recent-list').html(reminder);
                            })
                            Swal.fire({
                                title: "Deleted!",
                                text: "Task reminder has been deleted.",
                                icon: "success"
                            });
                        }
                    }
                })
            }
        });
    })

    $(document).on('click', '.day', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.toggleClass('dayClicked'); // Toggle the dayClicked class on the clicked button
        var anyDayClicked = $('.dayClicked').length > 0; // Check if any .dayClicked elements exist
        // Enable or disable the repeat_type select based on presence of dayClicked class
        $('#repeat_type').prop('disabled', anyDayClicked);
        $('#upd_repeat_type').prop('disabled', anyDayClicked);

        // Check if the background color is currently #00a8ff
        if ($(this).css('background-color') === 'rgb(0, 168, 255)') {
            // Toggle to default styles if current background color is #00a8ff
            $(this).css({
                'background-color': '',
                'border': '',
                'color': ''
            });
            $(this).removeClass('dayClicked')
        } else {
            // Toggle to specified styles if current background color is not #00a8ff
            $(this).css({
                'background-color': '#00a8ff',
                'border': '1px solid #00a8ff',
                'color': '#fff'
            });
            $(this).addClass('dayClicked')
        }
    });

    // Edit reminders
    $(document).on('click', '.reminderList', function () {
        const id = $(this).attr('value');
        $('#titleHeader').text('Edit Reminder');
        $.ajax({
            type: 'post',
            url: 'controller/reminder_byid.php',
            data: { id: id },
            success: function (html) {
                $('#edit-modal').modal('show')
                $('#Edit-reminderForm .modal-body').html(html)
                $('.modal #datepicker2').datepicker();
            }
        })

    });
    // Edit recent
    $(document).on('click', '.recentList', function () {
        const id = $(this).attr('value');
        $('#titleHeader').text('Set Reminder');
        $.ajax({
            type: 'post',
            url: 'controller/reminder_byid.php',
            data: { id: id },
            success: function (html) {
                $('#edit-modal').modal('show')
                $('#Edit-reminderForm .modal-body').html(html)
                $('.modal #datepicker2').datepicker();
            }
        })

    });

    $(document).on('change', '#repeat', function () {
        var ison = $(this).is(':checked');
        if (ison) {
            $('.day').attr('disabled', false);
            $('#repeat_type').attr('disabled', false);
            $('#upd_repeat_type').attr('disabled', false);
        } else {
            $('.day').attr('disabled', true);
            $('#repeat_type').attr('disabled', true);
            $('#upd_repeat_type').attr('disabled', true);

        }
    });

    // update reminder
    $('#Edit-reminderForm').on('submit', function (e) {
        e.preventDefault();
        const formdata = $(this).serialize();
        let repeat = [];
        $('#Edit-reminderForm .dayClicked').each(function () {
            repeat.push($(this).attr('value'))
        });
        var on = $('#Edit-reminderForm #repeat').is(':checked') ? 1 : 0;
        if (on > 0) {
            if (repeat.length == 0) {
                repeat.push($('.modal #upd_repeat_type option:selected').val())
                console.log(repeat)
                if (repeat.length == 0) {
                    Toaster('warning', 'Please select a day.');
                    return false;
                }
            }
        }
        const mydata = `${formdata}&repeat=${repeat.join(',')}&is_repeat=${on}`;
        $.ajax({
            type: 'post',
            url: 'controller/upd_reminder.php',
            data: mydata,
            success: function () {
                Toaster('success', 'The reminder has been successfully updated.')
                getReminders().then((reminder) => {
                    $('#reminder-list').html(reminder);
                });
                getRecentUsed().then((reminder) => {
                    $('#recent-list').html(reminder);
                })
            }
        })
    })

    // add reminder
    $('#reminderForm').on('submit', function (e) {
        e.preventDefault();
        const formdata = $(this).serialize();
        let repeat = [];
        $('#reminderForm .dayClicked').each(function () {
            repeat.push($(this).attr('value'))
        });
        var on = $('#repeat').is(':checked') ? 1 : 0;
        if (on > 0) {
            if (repeat.length == 0) {
                repeat.push($('#repeat_type option:selected').val())
                if (repeat.length == 0) {
                    Toaster('warning', 'Please select a day.');
                    return false;
                }

            }
        }
        const mydata = `${formdata}&repeat=${repeat.join(',')}&is_repeat=${on}`;
        $.ajax({
            type: 'post',
            url: 'controller/save_reminder.php',
            data: mydata,
            success: function (res) {
                res > 0 ? Toaster('success', 'The reminder has been successfully set.') : Toaster('error', 'Action Fail.')
                getReminders().then((reminder) => {
                    $('#reminder-list').html(reminder);
                });
            }
        });
    });

    function ut() {
        const today = new Date();
        $('.digital').html(today.toLocaleTimeString());
        // Get day of the week as a number (0-6)
        const dayOfWeekNum = today.getDay();
        const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        // Get day of the month (1-31)
        const dayOfMonth = today.getDate();

        // Get month as a number (0-11)
        const monthNum = today.getMonth();
        const monthsOfYear = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Get full year (e.g., 2024)
        const fullYear = today.getFullYear();

        // Construct the formatted date string
        const formattedDate = `${daysOfWeek[dayOfWeekNum]} - ${dayOfMonth} ${monthsOfYear[monthNum]} ${fullYear}`;

        // Display the formatted date
        $('.today').html(formattedDate);
    }
});