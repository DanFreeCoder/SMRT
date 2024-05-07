$(document).ready(function () {

    "use strict";
    // datatable setting
    $('.table-data').DataTable({
        'lengthChange': false,
        'searching': false,
        'ordering': false,
        pageLength: 5
    });
    // display task
    getActiveTask();
    getCompleteTask();
    getAllTask();

    function reset() {
        $('.todo-all').html('')
        $('.todo-active').html('')
        $('.todo-complete').html('')
        // display task
        getActiveTask();
        getCompleteTask();
        getAllTask();
    }

    function getActiveTask() {
        const status = 1;
        $.ajax({
            type: 'post',
            url: 'controller/taskforUser.php',
            data: {
                status: status
            },
            dataType: 'json',
            success: function (data) {
                data.forEach((d) => {
                    $('.todo-active').append(`
                        <div class="todo-item" data-info="${d.id}">
                            <span>${d.task_name}</span>
                        </div>`);
                })
            }
        });
    }


    function getCompleteTask() {
        const status2 = 2;
        $.ajax({
            type: 'post',
            url: 'controller/taskforUser.php',
            data: {
                status: status2
            },
            dataType: 'json',
            success: function (data) {
                data.forEach((d) => {
                    $('.todo-complete').append(`
                    <div class="todo-item complete" data-info="${d.id}">
                        <span>${d.task_name}</span>
                    </div>`);
                })
            }
        });
    }

    function getAllTask() {
        // ALL TASK
        $.ajax({
            type: 'post',
            url: 'controller/all_taskforUser.php',
            dataType: 'json',
            success: function (data) {
                data.forEach((d) => {
                    $('.todo-all').append(`
                    <div class="todo-item ${d.status == 2 ? 'complete' : ''}" data-info="${d.id}">
                        <span>${d.task_name}</span>
                    </div>`);
                })
            }
        });
    }

    function getlogs_data(task_id) {
        $.ajax({
            type: 'post',
            url: 'controller/task_details.php',
            data: { id: task_id },
            dataType: 'json',
            success: function (data) {
                $('#task_title').text(data[0].task_name)
                $('#timeline').text(new Date(data[0].timeline).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric' }))
                $('#status').val(data[0].status)
                $('#assigner').val(data[0].assigned_by)
                $('#urgency').val(data[0].urgency)
                $('#desctext').val(data[0].add_comment)
                $('#date_created').text(new Date(data[0].created_at).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric' }))
                var creationDate = new Date(data[0].created_at)
                $.ajax({
                    type: 'post',
                    url: 'controller/last_logs.php',
                    data: { task_id: task_id },
                    success: function (d) {
                        var last_logs = new Date(d);
                        // Calculate the time difference in milliseconds
                        var timeDifference = last_logs - creationDate;
                        // Convert milliseconds to days (assuming 1 day = 24 * 60 * 60 * 1000 milliseconds)
                        var accumulatedDays = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                        $('#accumulated').text(`${accumulatedDays ? accumulatedDays : 0}` + ' ' + `${accumulatedDays > 1 ? 'Days' : 'Day'}`)
                    }
                })
            }
        });
        $.ajax({
            type: 'post',
            url: 'controller/logs.php',
            data: { task_id: task_id },
            dataType: 'json',
            success: function (data) {
                $('.logs-data').html('');

                $.ajax({
                    type: 'post',
                    url: 'controller/first_logs_byid.php',
                    data: { task_id: task_id },
                    success: function (resdata) {
                        var firstlog = resdata;
                        data.forEach((d) => {
                            // Calculate the time difference in milliseconds
                            var timeDifference = new Date(d.date_logs) - new Date(firstlog);
                            // Convert milliseconds to days (assuming 1 day = 24 * 60 * 60 * 1000 milliseconds)
                            var Days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                            var formattedDate = new Date(d.date_logs).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric' });
                            $('.logs-data').append(
                                `<tr>
                                    <td>${formattedDate}</td>
                                    <td>${d.name}</td>
                                    <td>${d.context}</td>
                                    <td>${Days}${Days > 1 ? ' Days' : ' Day'}</td>
                                </tr>`
                            )
                        });
                    }
                })
            }
        })
    }

    $('#newTask').on('click', () => $('#exampleModal').modal('show'));

    // get users details
    $('#assignbtn').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'controller/users.php',
            dataType: 'json',
            success: function (data) {
                $('#users').html('')
                $('#users').append('<option value="0" disabled selected>Choose handler</option>')
                data.forEach((d) => {
                    $('#users').append(`<option value="${d.id}">${d.firstname} ${d.lastname}</option>`);
                })
            }
        });
    })


    var todo = function () {
        $(document).on('click', '.todo-list .todo-item input', function () {
            if ($(this).is(':checked')) {
                $(this).parent().parent().parent().toggleClass('complete');
            } else {
                $(this).parent().parent().parent().toggleClass('complete');
            }
        });

        $(document).on('click', '.todo-nav .all-task', function () {
            $('.todo-list').removeClass('only-active');
            $('.todo-list').removeClass('only-complete');
            $('.todo-nav li.active').removeClass('active');
            $(this).addClass('active');
        });

        $(document).on('click', '.todo-nav .active-task', function () {
            $('.todo-list').removeClass('only-complete');
            $('.todo-list').addClass('only-active');
            $('.todo-nav li.active').removeClass('active');
            $(this).addClass('active');
        });

        $(document).on('click', '.todo-nav .completed-task', function () {
            $('.todo-list').removeClass('only-active');
            $('.todo-list').addClass('only-complete');
            $('.todo-nav li.active').removeClass('active');
            $(this).addClass('active');
        });

        $(document).on('click', '#uniform-all-complete input', function () {
            if ($(this).is(':checked')) {
                $('.todo-item .checker span:not(.checked) input').click();
            } else {
                $('.todo-item .checker span.checked input').click();
            }
        });

        $(document).on('click', '.remove-todo-item', function () {
            $(this).parent().remove();
        });
    };

    todo();

    // get task logs
    $(document).on('click', '.todo-item', function () {
        $('.todo-item').css('background-color', '#f7f7f7')
        const task_id = $(this).attr('data-info');
        $('#task_id').val(task_id)
        getlogs_data(task_id)
        $(this).css('background-color', '#dfe6e9')
    });


    $('#logsForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();
        const first = formData.split('&')[1]
        const task_id = first.split('=')[1]
        const assigner = $('#assigner').val();
        $.ajax({
            type: 'post',
            url: 'controller/add_logs.php',
            data: formData,
            success: function (res) {
                if (res > 0) {
                    $.ajax({
                        type: 'post',
                        url: 'controller/user_byid.php',
                        data: { id: assigner },
                        dataType: 'json',
                        success: function (data) {
                            data.forEach((d) => {
                                var email = d.email;
                                var fullname = d.fullname;
                                var task_name = $('#task_title').text()
                                var notification = `I'm writing to inform you that the handler has updated the logs for the task "${task_name}" you assigned.
                               `;
                                var detailsData = `fullname=${fullname}&notification=${notification}&email=${email}`;
                                $.ajax({
                                    type: 'post',
                                    url: 'controller/emailTo.php',
                                    data: detailsData,
                                    success: function (res) {
                                        if (res > 0) {
                                            console.log('emailed')
                                            Toaster('success', 'Logs Updated')
                                            getlogs_data(task_id)
                                            $('#context').val('')
                                        }
                                    }
                                })
                            })
                        }
                    })

                }
            }
        })
    });

    $('#ondesc').on('click', () => $('#descriptionModal').modal('show'))
});