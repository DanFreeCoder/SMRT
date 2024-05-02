<?php include_once 'partials/header.php'; ?>
<!-- Page content-->
<div class="main-container" style="margin-top: 80px; overflow-x:hidden;">
    <input type="text" class="session-data" value="<?php echo $_SESSION['access_type']; ?>" hidden>
    <div class="row">
        <div class="col-lg-3">
            <!-- dashboard section -->
            <div class="row">
                <div class="card card-white">
                    <div class="card-header" style="background-color:transparent; border:none;">
                        <div class="btn custom-btn form-control" id="newTask" data-bs-target="#exampleModal"><i class="fa-solid fa-plus"></i> New Task</div>
                    </div>
                    <div class="card-body" style="height: 450px; max-height:450px; overflow-y: auto;">
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link active" id="btn-all" aria-current="page" href="#" data-bs-toggle="tab" data-bs-target="#home-tab-pane">All</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="btn-active" href="#" data-bs-toggle="tab" data-bs-target="#profile-tab-pane">Active</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="btn-complete" href="#" data-bs-toggle="tab" data-bs-target="#contact-tab-pane">Complete</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active todo-all todo-list" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                <!-- jquery -->
                            </div>
                            <div class="tab-pane fade todo-active todo-list" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <!-- jquery -->
                            </div>
                            <div class="tab-pane fade todo-complete todo-list" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                <!-- jquery -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Side widgets-->
        <div class="col-lg-9">
            <!-- Side widget-->
            <div class="card mb-4">
                <div class="card-header" style="background-color:transparent; position:relative;">
                    <div class="d-flex justify-content-between mb-0">
                        <i class="fa-solid fa-bars-progress"> <span style="font-size: small;" id="task_title"></span></i>
                        <span><i class="fa-solid fa-ranking-star"></i> <select name="status" id="status" style="pointer-events:none;">
                                <option value="0" selected></option>
                                <option value="1">Active</option>
                                <option value="2">Completed</option>
                            </select></span>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-0">
                    <span>Total Accumulated: <span id="accumulated"></span></span>
                    <a href="javascript:void(0)" id="ondesc">See descriptions</a>
                </div>
                <div class="card-body m-0" style="max-height: 370px; height:370px; overflow-y: auto;">
                    <table class="table-data table table-striped table-responsive">
                        <thead>
                            <tr>
                                <?php echo $_SESSION['access_type'] == 3 ? ' <th class="no-sort"><i class="fa-solid fa-location-arrow"></i></th>' : ''  ?>
                                <th class="no-sort">DATE</th>
                                <th class="no-sort">NAME</th>
                                <th class="no-sort">CONTEXT</th>
                                <th class="no-sort">Days</th>
                            </tr>
                        </thead>
                        <tbody class="logs-data">
                            <!-- jquery -->
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between">
                    <p>Completion Date: <i class="fa-regular fa-calendar"> <span style="font-size: small;" id="timeline"></span></i></p>
                    <p>Urgency: <select name="urgency" id="urgency" style="<?php echo ($_SESSION['access_type'] != 3) ? 'pointer-events:none;' : ''; ?>">
                            <option value="0" selected></option>
                            <option value="1">Low</option>
                            <option value="2">Mid</option>
                            <option value="3">High</option>
                        </select></p>
                </div>

                <div class="card-footer" style="border:none; background-color:transparent;">
                    <?php
                    if ($_SESSION['access_type'] == 3) {
                        echo '
                        <div class="d-flex justify-content-end">
                            <a href="#" id="customlogs">Enter custom date logs?</a>
                        </div>
                         ';
                    }
                    ?>

                    <form id="logsForm">
                        <div class="input-group">
                            <input class="form-control" type="text" name="context" id="context" placeholder="Enter text..." required />
                            <input type="text" name="task_id" id="task_id" hidden />
                            <button class="btn custom-btn" id="button-logs" type="submit">UPDATE LOGS</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="modalForm">
                <div class="modal-content">
                    <div class="modal-body">
                        <input type="text" name="task_name" id="task_name" class="form-control mb-3" placeholder="Task name here..." required>
                        <textarea name="description" id="description" class="form-control mb-3" placeholder="Description"></textarea>
                        <div class="input-group flex-nowrap mb-3">
                            <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-calendar-day"></i> Due Date</span>
                            <input type="date" class="form-control" name="due-date" placeholder="" required>
                        </div>
                        <select name="urgency" id="urgency" class="form-control">
                            <option value="0" disabled selected>Select Urgency</option>
                            <option value="1">Low</option>
                            <option value="2">Mid</option>
                            <option value="3">High</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group gap-5">
                            <button type="button" class="btn btn-light" id="assignbtn" name="user_id"><i class="fa-solid fa-chalkboard-user"></i> <span id="ass_text" name="ass_text">Assign to</span></button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn custom-btn">Add Task</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--User Modal -->
    <div class="modal fade" id="UserModal" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="UserModalLabel">Assign to</h1>
                </div>
                <div class="modal-body" id="Usermodal-body">
                    <select name="users" id="users" class="form-control">

                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- custom-date-logs -->
    <div class="modal fade" id="date_logs_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="cus_logsForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6>Enter custom date logs?</h6>
                    </div>
                    <div class="modal-body">
                        <input type="date" class="form-control" name="date-logs" id="date-logs">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="skip">Skip</button>
                        <button type="button" class="btn btn-primary" id="continue">Continue</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- edit-date-logs -->
    <div class="modal fade" id="edit_date_logs_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="cus_logsForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6>Enter custom date logs?</h6>
                    </div>
                    <div class="modal-body">
                        <input type="date" class="form-control" name="upd-date-logs" id="upd-date-logs">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancel">cancel</button>
                        <button type="button" class="btn btn-success" id="update_logs">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Description</h6>
                </div>
                <div class="modal-body">
                    <textarea name="desctext" id="desctext" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'partials/footer.php'; ?>
<script src="js/manager.js"></script>

</body>

</html>