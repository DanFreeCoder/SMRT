$(document).ready(function () {

    "use strict";
    // display task
    getActiveTask();
    getCompleteTask();
    ClosedtaskforUser();

    async function getActiveTask() {
        const status = 1;
        const data = await $.ajax({
            type: 'post',
            url: 'controller/taskforUser.php',
            data: { status },
            dataType: 'json'
        })
        data.forEach((d) => {
            $('.todo-active').append(`
                <div class="todo-item" data-info="${d.id}">
                    <span>${d.task_name}</span>
                </div>`);
        })
    }


    async function getCompleteTask() {
        const status = 2;
        const data = await $.ajax({
            type: 'post',
            url: 'controller/taskforUser.php',
            data: { status },
            dataType: 'json'
        });
        data.forEach((d) => {
            $('.todo-complete').append(`
            <div class="todo-item" data-info="${d.id}">
                <span>${d.task_name}</span>
            </div>`);
        })
    }

    async function ClosedtaskforUser() {
        const status = 3;
        const data = await $.ajax({
            type: 'post',
            url: 'controller/taskforUser.php',
            data: { status },
            dataType: 'json'
        });
        data.forEach((d) => {
            $('.todo-all').append(`
            <div class="todo-item complete" data-info="${d.id}">
                <span>${d.task_name}</span>
            </div>`);
        })

    }

    function getlogs_data(task_id) {
        $.ajax({
            type: 'post',
            url: 'controller/task_details.php',
            data: { id: task_id },
            dataType: 'json',
            success: function (data) {
                $('#task_title').text('');
                $('#desctext').text('')
                $('#task_title').append('<i class="fa-solid fa-bars-progress"></i> ' + data[0].task_name)
                $('#timeline').text(new Date(data[0].timeline).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric' }))
                $('#status').text(data[0].status == 1 ? 'Active' : 'Complete')
                $('#urgency').val(data[0].urgency)
                $('#desctext').append('<b>Description:</b> ' + data[0].add_comment)
                $('#date_created').text(new Date(data[0].created_at).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric' }))
                $('#assigned_by').text(data[0].assigned_by);
                var creationDate = new Date(data[0].created_at)
                $('#action').html(data[0].status == 1 ? `<button class="btn btn-sm btn-success mark_done" value="${task_id}"><i class="fa-regular fa-circle-check"></i> Mark as done</button>` : '');
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
                        $('#accumulated').text(`Total Accumulated: ${accumulatedDays ? accumulatedDays : 0}` + ' ' + `${accumulatedDays > 1 ? 'Days' : 'Day'}`)
                    }
                })
            }
        });
        $.ajax({
            type: 'post',
            url: 'controller/logs.php',
            data: { task_id: task_id },
            // dataType: 'json',
            success: function (html) {
                // Update the content of .logs-data with the received HTML
                $('.table-data').html(html);
                $('.session-data').val() != 3 ? $('.vip-edit').remove() : '';

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

    //UPDATE LOGS
    $('#logsForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();
        const first = formData.split('&')[1]
        const task_id = first.split('=')[1]
        $.ajax({
            type: 'post',
            url: 'controller/add_logs.php',
            data: formData,
            success: function (res) {
                if (res > 0) {
                    $.ajax({
                        type: 'post',
                        url: 'controller/assignerid_byTask.php',
                        data: { id: task_id },
                        success: function (assigner) {
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
                    })


                }
            }
        })
    });

    $('#ondesc').on('click', () => $('#descriptionModal').modal('show'))
    // mark done
    $(document).on('click', '.mark_done', function () {
        const id = $(this).val();
        const status = 2;
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, mark done"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: 'controller/upd_task.php',
                    data: { id: id, status: status },
                    success: function (res) {
                        if (res > 0) {
                            $.ajax({
                                type: 'post',
                                url: 'controller/mark_date.php?action=done',
                                data: { id: id },
                                success: function () {
                                    Swal.fire({
                                        title: "Done!",
                                        text: "The task has been successfully done.",
                                        icon: "success"
                                    });
                                    $('.todo-active').html('')
                                    $('.todo-complete').html('')
                                    $('.todo-all').html('')
                                    getlogs_data(id);
                                    getActiveTask();
                                    getCompleteTask();
                                    ClosedtaskforUser();
                                }
                            })
                        }
                    }
                })
            }
        });
    })
});