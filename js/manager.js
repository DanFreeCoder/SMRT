$(document).ready(function () {

    "use strict";

    function firstLoad() {

    }
    // display task
    getTask();

    // filter staff
    $.ajax({
        type: 'post',
        url: 'controller/users.php',
        dataType: 'json',
        success: function (data) {
            $('#filter').html('')
            $('#filter').html(`<option value="0" disabled selected>FILTER HANDLER</option>`);
            data.forEach((d) => {
                $('#filter').append(`<option value="${d.id}">${d.firstname} ${d.lastname}</option>`);
            })
        }
    });



    // filter by staff
    $('#filter').on('change', function () {
        const id = $(this).val();
        filterTaskby(id)
        $('#task_title').text('');
        $('#timeline').text('');
        $('#status').text('')
        $('#urgency').val(0)
        $('#desctext').text('')
        $('#date_created').text('')
        $('.table-data').html('');
        $('#DataTables_Table_0_wrapper').hide();
        $('#accumulated').text('')
    });


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

    $('#reset').on('click', function () {
        location.reload(true)
    });

    function reset() {
        $('.todo-all').html('')
        $('.todo-active').html('')
        $('.todo-complete').html('')
        // display task
        getTask();
    }

    function getTask() {
        $.ajax({
            type: 'post',
            url: 'controller/task.php',
            dataType: 'json',
            success: function (data) {
                $('.todo-active').html('')
                $('.todo-complete').html('')
                $('.todo-all').html('')
                data.forEach((d) => {
                    if (d.status == 1) { // active task
                        $('.todo-active').append(`
                        <div class="todo-item" data-info="${d.id}">
                            <div class="d-flex justify-content-between">
                                <div class="checker"><span class=""><input type="checkbox" value="${d.id}" ${d.status == 2 ? 'checked' : ''}></span></div>
                                <span>${d.task_name}</span>
                                <a href="javascript:void(0)" data-bs-toggle="dropdown" ><i class="fa-solid fa-ellipsis-vertical fs-5"></i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item re-assign" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-user-group text-warning"></i> Reassign</a></li>
                                        <li ${$('.session-data').val() != 3 ? 'hidden' : ''}><a class="dropdown-item edit-created_date" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-file-pen text-success"></i> Edit created date</a></li>
                                        <li><a class="dropdown-item remove-task" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-trash text-danger"></i> Remove</a></li>
                                    </ul>
                                </a>
                            </div>
                        </div>`);
                    } else if (d.status == 2) { //complete task
                        $('.todo-complete').append(`
                        <div class="todo-item complete" data-info="${d.id}">
                                <div class="checker"><span class=""><input type="checkbox" value="${d.id}" ${d.status == 2 ? 'checked' : ''}></span></div>
                                <span>${d.task_name}</span>
                        </div>`);
                    }

                    // all task
                    $('.todo-all').append(`
                    <div class="todo-item ${d.status == 2 ? 'complete' : ''}" data-info="${d.id}">
                        <div class="d-flex justify-content-between">
                            <div class="checker"><span class=""><input type="checkbox" value="${d.id}" ${d.status == 2 ? 'checked' : ''}></span></div>
                            <span>${d.task_name}</span>
                            <a href="javascript:void(0)" data-bs-toggle="dropdown" ><i class="fa-solid fa-ellipsis-vertical fs-5"></i>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item re-assign" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-user-group text-warning"></i> Reassign</a></li>
                                    <li ${$('.session-data').val() != 3 ? 'hidden' : ''}><a class="dropdown-item edit-created_date" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-file-pen text-success"></i> Edit created date</a></li>
                                    <li><a class="dropdown-item remove-task" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-trash text-danger"></i> Remove</a></li>
                                </ul>
                            </a>
                        </div>
                    </div>`);

                })
            }
        });
    }

    function filterTaskby(id) {
        $.ajax({
            type: 'post',
            url: 'controller/task_filter_by.php',
            data: {
                id: id,
            },
            dataType: 'json',
            success: function (data) {
                $('.todo-active').html('')
                $('.todo-complete').html('')
                $('.todo-all').html('')
                data.forEach((d) => {
                    if (d.status == 1) { // active task
                        $('.todo-active').append(`
                        <div class="todo-item" data-info="${d.id}">
                            <div class="d-flex justify-content-between">
                                <div class="checker"><span class=""><input type="checkbox" value="${d.id}"></span></div>
                                <span>${d.task_name}</span>
                                <a href="javascript:void(0)" data-bs-toggle="dropdown" ><i class="fa-solid fa-ellipsis-vertical fs-5"></i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item re-assign" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-user-group text-warning"></i> Reassign</a></li>
                                        <li><a class="dropdown-item edit-created_date" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-file-pen text-success"></i> Edit created date</a></li>
                                        <li><a class="dropdown-item remove-task" href="javascript:void(0)" value="${d.id}"><i class="fa-solid fa-trash text-danger"></i> Remove</a></li>
                                    </ul>
                                </a>
                            </div>
                        </div>`);
                    } else if (d.status == 2) { // complete task
                        $('.todo-complete').append(`
                        <div class="todo-item complete" data-info="${d.id}">
                                <div class="checker"><span><input type="checkbox" value="${d.id}" checked /></span></div>
                                <span>${d.task_name}</span>
                        </div>`);
                    }
                    // all task
                    $('.todo-all').append(`
                        <div class="todo-item ${d.status == 2 ? 'complete' : ''}" data-info="${d.id}">
                            <div class="d-flex justify-content-between">
                                <div class="checker"><span class=""><input type="checkbox" value="${d.id}" ${d.status == 2 ? 'checked' : ''}></span></div>
                                <span>${d.task_name}</span>
                                <a href="javascript:void(0)" data-bs-toggle="dropdown" ><i class="fa-solid fa-ellipsis-vertical fs-5"></i>
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
        $('#skip').val(task_id);//set the id for last logs of selected task

        // get assignee
        $.ajax({
            type: 'post',
            url: 'controller/assignee_byid.php',
            data: { id: task_id },
            dataType: 'json',
            success: function (resdata) {
                const task_user_id = resdata.trim(); // Trim to remove any leading or trailing whitespace
                var task_user_id_arr;
                if (task_user_id.includes(',')) {
                    // separate content to make a loop and remove some double qoute
                    task_user_id_arr = task_user_id.replace(/"/g, '').split(',');
                } else {
                    task_user_id_arr = [task_user_id.replace(/"/g, '')]; // Convert single value to array
                }


                // get fullname of assignee
                $.ajax({
                    type: 'post',
                    url: 'controller/user_byid.php',
                    data: { id: task_user_id_arr.join(',') },
                    dataType: 'json',
                    success: function (userid) {
                        var html = '';
                        userid.forEach((j) => {
                            var fullnameArray = j.fullname;
                            for (let i = 0; i < fullnameArray.length; i++) {
                                var fullname = fullnameArray[i];
                                html += `${fullname}<br>`;
                            }
                        })

                        // append assignee
                        $('#tooltip').attr('title', `${html}`);
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    }

                })
            }
        })
        $.ajax({
            type: 'post',
            url: 'controller/task_details.php',
            data: { id: task_id },
            dataType: 'json',
            success: function (data) {
                $('#task_title').text('');
                $('#task_title').append('<i class="fa-solid fa-bars-progress"></i> ' + data[0].task_name)
                $('#timeline').text(new Date(data[0].timeline).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric' }));
                $('#status').text(data[0].status == 1 ? 'Active' : 'Complete')
                $('#urgency').val(data[0].urgency)
                $('#desctext').text('Description: ' + data[0].add_comment)
                $('#date_created').text(new Date(data[0].created_at).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric' }))
                $('#assigned_by').text(data[0].assigned_by);
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
                        $('#accumulated').text(`Total Accumulated:  ${accumulatedDays ? accumulatedDays : 0}` + ' ' + `${accumulatedDays > 1 ? 'Days' : 'Day'}`)
                    }
                })

            }
        })
        $.ajax({
            type: 'post',
            url: 'controller/logs.php',
            data: { task_id: task_id },
            // dataType: 'json',
            success: function (html) {
                // Update the content of .logs-data with the received HTML
                $('.table-data').html(html);
                // $('.session-data').val() != 3 ? $('.vip-edit').remove() : '';

                // Destroy the existing DataTables instance (if initialized)
                if ($.fn.DataTable.isDataTable('.table-data')) {
                    $('.table-data').DataTable().destroy();
                }

                // Reinitialize DataTables with updated content
                $('.table-data').DataTable({
                    // DataTables options, if any
                    "pageLength": 5,
                    "paging": true,  // Enable pagination
                    "lengthChange": false,  // Enable the page length change option
                    "searching": false,  // Enable searching/filtering
                    "info": true,  // Show table information (e.g., "Showing 1 to 10 of 20 entries")
                    "autoWidth": true,  // Disable auto width calculation (if needed)
                    "order": [],  // Disable initial sorting (if needed)
                    "columnDefs": [
                        { "orderable": false, "targets": "no-sort" }  // Disable sorting for columns with class "no-sort"
                    ]
                });
                // Hide the last penbtn icon
                $('.logs-data tr:last').find('.penbtn').hide();


            }
        });
    }
    //dad?
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
        const filter_id = $('#filter option:selected').val()
        // complete
        if ($(this).is(':checked')) {
            $.ajax({
                type: 'post',
                url: 'controller/upd_task.php',
                data: { id: id, status: 2 },
                success: function (res) {
                    if (res > 0) {
                        if (filter_id > 0) {
                            filterTaskby($('#filter option:selected').val())
                            getlogs_data(id)
                        } else {
                            getTask();
                            getlogs_data(id)
                        }

                    }

                }
            })
        } else {
            //active
            $.ajax({
                type: 'post',
                url: 'controller/upd_task.php',
                data: { id: id, status: 1 },
                success: function (res) {
                    if (res > 0) {
                        if (filter_id > 0) {
                            filterTaskby($('#filter option:selected').val())
                            getlogs_data(id)
                        } else {
                            getTask();
                            getlogs_data(id)
                        }

                    }
                }
            })
        }
    })


    $('#newTask').on('click', () => $('#exampleModal').modal('show'));

    // get users details
    $('#assignbtn').on('click', function (e) {
        e.preventDefault();
        $('.modal #users').picker('destroy')//reset the picker
        $.ajax({
            type: 'post',
            url: 'controller/users.php',
            dataType: 'json',
            success: function (data) {
                $('#users').html('')
                data.forEach((d) => {
                    $('#users').append(`<option value="${d.id}">${d.firstname} ${d.lastname}</option>`);
                })
                $('.modal #users').picker({
                    search: true,
                    texts: { trigger: "Select assignee", noResult: "No results", search: "Find..." },
                    searchAutofocus: true
                    // limit: 2 //limit a select
                });
            }
        });
    });

    // open modal
    $(document).on('click', '#assignbtn', () => $('#UserModal').modal('show'))


    // add task
    $('#modalForm').on('submit', function (e) {
        e.preventDefault();
        var FormData = $(this).serialize();
        const user_id = $('.modal #users').val();
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
                        data: { id: user_id.join(',') },
                        dataType: 'json',
                        success: function (data) {
                            var timeline = new Date($('#due-date').val()).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric' })
                            var notification = `I'm reaching out to inform you that you have been assigned a new task. The details of the task are as follows:<br><br>
                                   Task Name: ${$('#task_name').val()} <br>
                                   Description: ${$('#description').val()} <br>
                                   Deadline: ${timeline} <br><br>
                                   Thank you for your dedication and commitment.`;
                            data.forEach((d) => {
                                var emailarray = d.email;
                                var fullnamearray = d.fullname;
                                for (var i = 0; i < fullnamearray.length; i++) {
                                    var fullname = fullnamearray[i];
                                    var email = emailarray[i];
                                    var detailsData = `fullname=${fullname}&notification=${notification}&email=${email}`;
                                    $.ajax({
                                        type: 'post',
                                        url: 'controller/emailTo.php',
                                        data: detailsData,
                                        success: function (res) {
                                            if (res > 0) {
                                                console.log('emailed')
                                                Toaster('success', 'Task has been add successfully.')
                                                $('#exampleModal').modal('hide')
                                                reset();
                                            }
                                        }
                                    })
                                }

                            })
                        }
                    })
                    //open the last added task
                    lastAddedTaskid().then(id => getlogs_data(id));
                }
            }
        })
    })

    function lastAddedTaskid() {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'post',
                url: 'controller/lastAddTaskid.php',
                success: function (id) {
                    resolve(id);
                },
                error: function (err) {
                    reject(err)
                }
            });
        })
    }

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
    $('#save').on('click', () => $('#UserModal').modal('hide'));

    // UPDATE LOGS
    $('#logsForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var first = formData.split('&')[1]
        var task_id = first.split('=')[1]
        var datelog = $('#date-logs').val();
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
                    // get assignee
                    $.ajax({
                        type: 'post',
                        url: 'controller/assignee_byid.php',
                        data: { id: task_id },
                        dataType: 'json',
                        success: function (resdata) {
                            const task_user_id = resdata.trim(); // Trim to remove any leading or trailing whitespace
                            var task_user_id_arr;
                            if (task_user_id.includes(',')) {
                                // separate content to make a loop and remove some double qoute
                                task_user_id_arr = task_user_id.replace(/"/g, '').split(',');
                            } else {
                                task_user_id_arr = [task_user_id.replace(/"/g, '')]; // Convert single value to array
                            }
                            // get fullname of assignee
                            $.ajax({
                                type: 'post',
                                url: 'controller/user_byid.php',
                                data: { id: task_user_id_arr.join(',') },
                                dataType: 'json',
                                success: function (userid) {
                                    userid.forEach((j) => {
                                        var fullnameArray = j.fullname;
                                        var emailArray = j.email;
                                        for (let i = 0; i < fullnameArray.length; i++) {
                                            var fullname = fullnameArray[i];
                                            var email = emailArray[i]
                                            var task_name = $('#task_title').text()
                                            var notification = `I'm writing to inform you that the assigner has updated the logs for the task "${task_name}" assigned to you.
                                                   `;
                                            var detailsData = `fullname=${fullname}&notification=${notification}&email=${email}`;
                                            //send Email
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

                                        }
                                    })
                                }

                            })
                        }
                    })
                }
            }
        })
    });

    // show custome logs modal
    $(document).on('click', '#customlogs', function (e) {
        e.preventDefault()
        var taskid = $('#skip').val();
        $.ajax({
            type: 'post',
            url: 'controller/last_logs.php',
            data: { task_id: taskid },
            success: function (lastlogs) {
                var format = lastlogs.split("-")
                var minDateString = `${format[1]}/${format[2]}/${format[0]}`;
                $("#date-logs").datepicker({
                    minDate: minDateString,
                });
            }
        })
        $('#date_logs_modal').modal('show')
    });

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
        const id = $(this).attr('value')
        $('#update_logs').val(id)
        $.ajax({
            type: 'post',
            url: 'controller/get_date_logs.php',
            data: { id: id },
            dataType: 'json',
            success: function (data) {
                $('.modal #context').val(data.content)
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
                        // hide edit logs when user is not vip
                        if ($('.session-data').val() != 3) {
                            $('#upd-date-logs').hide()
                        }
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
        const context = $('.modal #context').val();
        $.ajax({
            type: 'post',
            url: 'controller/upd_date_logs.php',
            data: {
                id: id,
                upd_date_logs: upd_logs,
                context: context
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
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: 'controller/del_task.php',
                    data: { id: id },
                    success: function (res) {
                        res > 0 ? Swal.fire({ title: "Deleted!", text: "Task has been deleted.", icon: "success" }) : '';
                        location.reload(true);
                    }
                })

            }
        });
    })

    // RE-ASSIGN TASK
    $(document).on('click', '.re-assign', function (e) {
        e.preventDefault();
        $('#users2').picker('destroy')//reset the picker

        const id = $(this).attr('value');
        $('#taskx2_id').val(id);
        $('#reassignModal').modal('show')

        $.ajax({
            type: 'post',
            url: 'controller/assignee_byid.php',
            data: { id: id },
            success: function (data2) {
                const task_user_id = data2.trim(); // Trim to remove any leading or trailing whitespace
                var task_user_id_arr;
                if (task_user_id.includes(',')) {
                    // separate content to make a loop and remove some double qoute
                    task_user_id_arr = task_user_id.replace(/"/g, '').split(',');
                } else {
                    task_user_id_arr = [task_user_id.replace(/"/g, '')]; // Convert single value to array
                }
                $.ajax({
                    type: 'post',
                    url: 'controller/users.php',
                    dataType: 'json',
                    success: function (data) {
                        $('.modal #users2').html('')
                        data.forEach((d) => {
                            // Check if d.id exists in task_user_id_arr to determine if option should be selected/// it return (true or false)
                            var isSelected = task_user_id_arr.includes(d.id.toString());
                            $('.modal #users2').append(`<option value="${d.id}" ${isSelected ? 'selected' : ''} > ${d.firstname} ${d.lastname}</option>`);
                        });
                        $('#users2').picker({
                            search: true,
                            texts: { trigger: "Add assignee", noResult: "No results", search: "Find..." },
                            searchAutofocus: true
                            // limit: 2 //limit a select
                        });
                    }
                });
            }
        })
    })

    $(document).on('click', '#upd_reassign', function () {
        const user_id = $('#users2').val()
        const task_id = $('#taskx2_id').val()
        const mydata = `user_id=${user_id}&task_id=${task_id}`;
        $.ajax({
            type: 'post',
            url: 'controller/upd_user_id.php',
            data: mydata,
            success: function (res) {
                if (res > 0) {
                    $.ajax({
                        type: 'post',
                        url: 'controller/user_byid.php',
                        data: { id: user_id.join(',') },
                        dataType: 'json',
                        success: function (data) {
                            var timeline = new Date($('#timeline').text()).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric' })
                            var notification = `I'm reaching out to inform you that a task has been <b>re-assigned</b> to you. The details of the task are as follows:<br><br>
                                    Task Name: ${$('#task_title').text()} <br>
                                    Description: ${$('#desctext').val()} <br>
                                    Deadline: ${timeline} <br><br>
                                    Thank you for your dedication and commitment.`;
                            data.forEach((d) => {
                                var emailArray = d.email;
                                var fullnameArray = d.fullname;
                                for (var i = 0; i < emailArray.length; i++) {
                                    var email = emailArray[i];
                                    var fullname = fullnameArray[i];
                                    var detailsData = `fullname=${fullname}&notification=${notification}&email=${email}`;
                                    $.ajax({
                                        type: 'post',
                                        url: 'controller/emailTo.php',
                                        data: detailsData,
                                        success: function (res) {
                                            if (res > 0) {
                                                Toaster('success', 'Assigned Successfully');
                                                $('#reassignModal').modal('hide')
                                            } else {
                                                Toaster('error', 'Assign Fail')
                                            }
                                        }
                                    })
                                }
                            })
                            reset();
                            getlogs_data(task_id)
                            console.log($(`.todo-item[data-info='${task_id}']`))
                            $(`.todo-item[data-info='${task_id}']`).css('background-color', '#dfe6e9')
                        }
                    })
                }
            }
        });
    });
});