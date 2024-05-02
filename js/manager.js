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
            url: 'controller/task.php',
            data: {
                status: status
            },
            dataType: 'json',
            success: function (data) {
                data.forEach((d) => {
                    $('.todo-active').append(`
                        <div class="todo-item" data-info="${d.id}">
                        <div class="checker"><span class=""><input type="checkbox" value="${d.id}" ${d.status == 2 ? 'checked' : ''}></span></div>
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
            url: 'controller/task.php',
            data: {
                status: status2
            },
            dataType: 'json',
            success: function (data) {
                data.forEach((d) => {
                    $('.todo-complete').append(`
                    <div class="todo-item complete" data-info="${d.id}">
                    <div class="checker"><span class=""><input type="checkbox" value="${d.id}" ${d.status == 2 ? 'checked' : ''}></span></div>
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
            url: 'controller/all_task.php',
            dataType: 'json',
            success: function (data) {
                data.forEach((d) => {
                    $('.todo-all').append(`
                    <div class="todo-item ${d.status == 2 ? 'complete' : ''}" data-info="${d.id}">
                    <div class="checker"><span class=""><input type="checkbox" value="${d.id}" ${d.status == 2 ? 'checked' : ''}></span></div>
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
                $('#timeline').text(data[0].timeline)
                $('#status').val(data[0].status)
                $('#urgency').val(data[0].urgency)
                $('#desctext').val(data[0].add_comment)
                var creationDate = new Date(data[0].created_at)
                var currentDate = new Date();
                // Calculate the time difference in milliseconds
                var timeDifference = currentDate - creationDate;

                // Convert milliseconds to days (assuming 1 day = 24 * 60 * 60 * 1000 milliseconds)
                var accumulatedDays = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                $('#accumulated').text(accumulatedDays + ' ' + `${accumulatedDays > 1 ? 'Days' : 'Day'}`)
            }
        })
        $.ajax({
            type: 'post',
            url: 'controller/logs.php',
            data: { task_id: task_id },
            dataType: 'json',
            success: function (data) {
                $('.logs-data').html('');
                data.forEach((d) => {
                    var formattedDate = new Date(d.date_logs).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric' });
                    $('.logs-data').append(
                        `<tr>
                            ${$('.session-data').val() == 3 ? `<td><a href="javascript:void(0)" class="text-warning edit-logs" value="${d.id}"><i class="fa-solid fa-pen"></i></a></td>` : ''}
                            <td>${formattedDate}</td>
                            <td>${d.name}</td>
                            <td>${d.context}</td>
                            <td>${d.days}</td>
                        </tr>`
                    )
                });
            }
        })
    }

    $('#status').on('change', function (e) {
        e.preventDefault();

    })

    $(document).on('change', '[type="checkbox"]', function (e) {
        e.preventDefault();
        const id = $(this).val()
        // complete
        if ($(this).is(':checked')) {
            $.ajax({
                type: 'post',
                url: 'controller/upd_task.php',
                data: { id: id, status: 2 },
                success: function (res) {
                    res > 0 ? reset() : '';
                    getlogs_data(id)
                }
            })
        } else {
            //active
            $.ajax({
                type: 'post',
                url: 'controller/upd_task.php',
                data: { id: id, status: 1 },
                success: function (res) {
                    res > 0 ? reset() : '';
                    getlogs_data(id)
                }
            })
        }
    })


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
    // open modal
    $(document).on('click', '#assignbtn', () => $('#UserModal').modal('show'))


    //select custom logs
    $('#cus_logsForm').on('submit', function (e) {
        const formdata = $(this).serialize();

        console.log(formdata)
    })

    // add task
    $('#modalForm').on('submit', function (e) {
        e.preventDefault();
        var FormData = $(this).serialize();
        const user_id = $('#assignbtn').val();
        FormData += `&user_id=${user_id}`
        $.ajax({
            type: 'post',
            url: 'controller/add_task.php',
            data: FormData,
            success: function (res) {
                if (res > 0) {
                    Toaster('success', 'Task has been add successfully.')
                    reset();
                }
            }
        })
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

    $(".add-task").keypress(function (e) {
        if ((e.which == 13) && (!$(this).val().length == 0)) {
            $('<div class="todo-item"><div class="checker"><span class=""><input type="checkbox"></span></div> <span>' + $(this).val() + '</span> <a href="javascript:void(0);" class="float-right remove-todo-item"><i class="icon-close"></i></a></div>').insertAfter('.todo-list .todo-item:last-child');
            $(this).val('');
        } else if (e.which == 13) {
            alert('Please enter new task');
        }
        $(document).on('.todo-list .todo-item.added input').click(function () {
            if ($(this).is(':checked')) {
                $(this).parent().parent().parent().toggleClass('complete');
            } else {
                $(this).parent().parent().parent().toggleClass('complete');
            }
        });
        $('.todo-list .todo-item.added .remove-todo-item').click(function () {
            $(this).parent().remove();
        });
    });

    // get task logs
    $(document).on('click', '.todo-item', function () {
        $('.todo-item').css('background-color', '#f7f7f7')
        const task_id = $(this).attr('data-info');
        $('#task_id').val(task_id)
        getlogs_data(task_id)
        $(this).css('background-color', '#dfe6e9')

    });

    // onchange user selection
    $('#users').on('change', () => {
        const id = $('#users option:selected').val();
        const name = $('#users option:selected').text();
        $('#ass_text').text(name);
        $('#assignbtn').val(id);
        $('#UserModal').modal('hide')
    });

    $('#logsForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var first = formData.split('&')[1]
        var task_id = first.split('=')[1]
        var datelog = $('#date-logs').val()
        var updatedFormData = `${formData}&date-logs=${datelog}`;
        if (task_id == '') {
            return false;
        }
        $.ajax({
            type: 'post',
            url: 'controller/add_logs.php',
            data: updatedFormData,
            success: function (res) {
                if (res > 0) {
                    Toaster('success', 'Logs Updated')
                    getlogs_data(task_id)
                    $('#context').val('')
                    $('#date-logs').val('')
                    $('#customlogs').text('Enter custom date logs?')
                }
            }
        })
    });

    // show custome logs modal
    $('#customlogs').on('click', () => $('#date_logs_modal').modal('show'));

    // hide custtom logs modal and clear value
    $('#skip').on('click', function () {
        $('#date_logs_modal').modal('hide')
        $('#date-logs').val('')
    });

    // continue date logs and remain value
    $('#continue').on('click', function () {
        var datelog = $('#date-logs').val()
        // Create a Date object from the local time
        var localDate = new Date(datelog);
        // Get the timezone offset for Manila (UTC+8)
        var manilaOffset = 8 * 60 * 60 * 1000; // 8 hours in milliseconds
        // Adjust the date to the Manila timezone
        var manilaTime = new Date(localDate.getTime() + manilaOffset);
        // Format the datetime string as "YYYY-MM-DD HH:MM:SS"
        var formattedDateLog = manilaTime.toISOString().slice(0, 19).replace('T', ' ');
        $('#customlogs').text(formattedDateLog)
        $('#date_logs_modal').modal('hide')
    })

    // edit date-logs
    $(document).on('click', '.edit-logs', function () {
        $('#edit_date_logs_modal').modal('show')
        const id = $(this).attr('value');
        $('#update_logs').val(id)
        $.ajax({
            type: 'post',
            url: 'controller/get_date_logs.php',
            data: { id: id },
            success: function (data) {
                $('#upd-date-logs').val(data)
            }
        })
    })
    // show custome logs modal
    $(document).on('click', '#cancel', () => $('#edit_date_logs_modal').modal('hide'));

    // update date logs
    $('#update_logs').on('click', function () {
        const id = $(this).val()
        const upd_logs = $('#upd-date-logs').val();
        $.ajax({
            type: 'post',
            url: 'controller/upd_date_logs.php',
            data: {
                id: id,
                upd_date_logs: upd_logs
            },
            success: function (res) {
                if (res > 0) {
                    Toaster('success', 'Date logs updated!')
                    setTimeout(() => {
                        getlogs_data($('#task_id').val(

                        ))
                    }, 1000)
                }

            }
        })
    })

    $('#ondesc').on('click', () => $('#descriptionModal').modal('show'))


    // change urgency
    $('#urgency').on('change', function () {
        const urgency = $(this).val()
        const id = $('#task_id').val()
        $.ajax({
            type: 'post',
            url: 'controller/upd_urgency.php',
            data: {
                urgency: urgency,
                id: id
            },
            success: function (res) {
                if (res > 0) {
                    Toaster('success', 'Urgency updated!')
                    setTimeout(() => {
                        getlogs_data($('#task_id').val(

                        ))
                    }, 1000)
                }

            }
        })
    })
});