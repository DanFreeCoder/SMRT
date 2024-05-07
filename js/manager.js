$(document).ready(function () {

    "use strict";


    // disable the past date in due date input date field
    var dtToday = new Date();
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if (month < 10)
        month = '0' + month.toString();
    if (day < 10)
        day = '0' + day.toString();
    var maxDate = year + '-' + month + '-' + day;
    $('#due-date').attr('min', maxDate);


    $("#date-logs").datepicker();
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
                            <div class="d-flex justify-content-between">
                                <div class="checker"><span class=""><input type="checkbox" value="${d.id}" ${d.status == 2 ? 'checked' : ''}></span></div>
                                <span>${d.task_name}</span>
                                <a href="javascript:void(0)" data-bs-toggle="dropdown" ><i class="fa-solid fa-ellipsis-vertical"></i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item re-assign" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-user-group text-warning"></i> Reassign</a></li>
                                        <li><a class="dropdown-item edit-created_date" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-file-pen text-success"></i> Edit created date</a></li>
                                        <li><a class="dropdown-item remove-task" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-trash text-danger"></i> Remove</a></li>
                                    </ul>
                                </a>
                            </div>
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
                        <div class="d-flex justify-content-between">
                            <div class="checker"><span class=""><input type="checkbox" value="${d.id}" ${d.status == 2 ? 'checked' : ''}></span></div>
                            <span>${d.task_name}</span>
                            <a href="javascript:void(0)" data-bs-toggle="dropdown" ><i class="fa-solid fa-ellipsis-vertical"></i>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item re-assign" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-user-group text-warning"></i> Reassign</a></li>
                                    <li><a class="dropdown-item edit-created_date" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-file-pen text-success"></i> Edit created date</a></li>
                                    <li><a class="dropdown-item remove-task" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-trash text-danger"></i> Remove</a></li>
                                </ul>
                            </a>
                        </div>
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
                $('#timeline').text(new Date(data[0].timeline).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric' }));
                $('#status').val(data[0].status)
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
        })
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
                                    ${$('.session-data').val() == 3 ? `<td><a href="javascript:void(0)" class="text-warning edit-logs" value="${d.id}"><i class="fa-solid fa-pen penbtn"></i></a></td>` : ''}
                                    <td>${formattedDate}</td>
                                    <td>${d.name}</td>
                                    <td>${d.context}</td>
                                    <td>${Days}${Days > 1 ? ' Days' : ' Day'}</td>
                                </tr>`
                            )
                        });
                    }
                })

                // Hide the last penbtn icon
                $('.logs-data tr:last').find('.penbtn').hide();
            }
        })
    }

    $(document).on('click', '.edit-created_date', function (e) {
        e.preventDefault();
        const id = $(this).attr('value');
        $('#edit_created_date_modal').modal('show')
        $.ajax({
            type: 'post',
            url: 'controller/get_created_at.php',
            data: { id: id },
            success: function (data) {
                var dateString = data
                var dateParts = dateString.split("-")
                var dateCreated = `${dateParts[1]}/${dateParts[2]}/${dateParts[0]}`;
                $('#task_created_at').val(dateCreated)
                $("#task_created_at").datepicker()
            }
        })
    });

    $(document).on('submit', '#date_created_taskForm', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $('#task_id').val();
        $.ajax({
            type: 'post',
            url: `controller/upd_task_date_created.php?id=${id}`,
            data: formData,
            success: function (res) {
                res > 0 ? Toaster('success', 'Task date created has been updated successfully.') : Toaster('error', 'Action Fail.')
                reset();
                getlogs_data(id)
                $('#edit_created_date_modal').modal('hide')
            }

        })
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
                    $.ajax({
                        type: 'post',
                        url: 'controller/user_byid.php',
                        data: { id: user_id },
                        dataType: 'json',
                        success: function (data) {
                            data.forEach((d) => {
                                var email = d.email;
                                var fullname = d.fullname;
                                var notification = `I'm reaching out to inform you that you have been assigned a new task. The details of the task are as follows:<br><br>
                               Task Name: ${$('#task_name').val()} <br>
                               Description: ${$('#description').val()} <br>
                               Deadline: ${$('#due-date').val()} <br><br>
                               Thank you for your dedication and commitment.
                               `;
                                var detailsData = `fullname=${fullname}&notification=${notification}&email=${email}`;
                                $.ajax({
                                    type: 'post',
                                    url: 'controller/emailTo.php',
                                    data: detailsData,
                                    success: function (res) {
                                        if (res > 0) {
                                            console.log('emailed')
                                            Toaster('success', 'Task has been add successfully.')
                                            reset();
                                        }
                                    }
                                })
                            })
                        }
                    })
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
        $('#customlogs').text(datelog)
        $('#date_logs_modal').modal('hide')
    })

    // edit date-logs
    $(document).on('click', '.edit-logs', function () {
        var task_id = $('#task_id').val()
        $("#upd-date-logs").datepicker("destroy");
        $('#edit_date_logs_modal').modal('show')
        const id = $(this).attr('value');
        $('#update_logs').val(id)
        $.ajax({
            type: 'post',
            url: 'controller/get_date_logs.php',
            data: { id: id },
            dataType: 'json',
            success: function (data) {
                $.ajax({
                    type: 'post',
                    url: 'controller/last_logs.php',
                    data: { task_id: task_id },
                    success: function (d) {
                        var dateString3 = d;
                        var dateParts3 = dateString3.split("-");
                        var dateString = data.date_logs;
                        var dateString2 = data.date_logs_prev;
                        var dateParts = dateString.split("-");
                        var dateParts2 = dateString2.split("-");
                        // change date format
                        var newDateString = `${dateParts[1]}/${dateParts[2]}/${dateParts[0]}`;
                        var minDateString = `${dateParts2[1]}/${dateParts2[2]}/${dateParts2[0]}`;
                        var maxDateString = `${dateParts3[1]}/${dateParts3[2]}/${dateParts3[0]}`;
                        $('#upd-date-logs').val(newDateString)
                        // date picker
                        $("#upd-date-logs").datepicker({
                            minDate: minDateString,
                            maxDate: newDateString == maxDateString ? '' : maxDateString,
                            defaultsDate: newDateString,
                        });

                    }
                })


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
                        getlogs_data($('#task_id').val())
                    }, 1000)
                    $('#edit_date_logs_modal').modal('hide');
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
                        getlogs_data($('#task_id').val())
                    }, 1000)
                }

            }
        })
    });


    // REMOVE TASK
    $(document).on('click', '.remove-task', function (e) {
        e.preventDefault();
        const id = $(this).attr('value');
        $.ajax({
            type: 'post',
            url: 'controller/del_task.php',
            data: { id: id },
            success: function (res) {
                res > 0 ? Toaster('success', 'The task has been removed successfully.') : Toaster('error', 'Action failed.');
                reset();
            }
        })
    })



    // RE-ASSIGN TASK
    $(document).on('click', '.re-assign', function (e) {
        e.preventDefault();
        const id = $(this).attr('value');
        $('#taskuser_id').val(id);
        $('#reassignModal').modal('show')

        $.ajax({
            type: 'post',
            url: 'controller/task_user_id.php',
            data: { id: id },
            success: function (data2) {
                const task_user_id = data2

                $.ajax({
                    type: 'post',
                    url: 'controller/users.php',
                    dataType: 'json',
                    success: function (data) {
                        $('#users2').html('')
                        data.forEach((d) => {
                            $('#users2').append(`<option value="${d.id}" ${task_user_id != d.id ? '' : 'selected'}>${d.firstname} ${d.lastname}</option>`);
                        })
                    }
                });
            }
        })

    })

    $(document).on('click', '#upd_reassign', function () {
        const user_id = $('#users2 option:selected').val()
        const task_id = $('#taskuser_id').val()
        const mydata = `user_id=${user_id}&task_id=${task_id}`;
        $.ajax({
            type: 'post',
            url: 'controller/upd_user_id.php',
            data: mydata,
            success: function (res) {
                res > 0 ? Toaster('success', 'Assigned Successfully') : Toaster('error', 'Assign Fail');
                $('#reassignModal').modal('hide')
            }
        });
    });
});