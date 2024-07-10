<?php include_once 'partials/header.php'; ?>
<?php if ($_SESSION['access_type'] != 2) {
    header("Location:controller/logout.php");
} ?>
<!-- Page content-->
<div class="main-container" style="margin-top: 80px; overflow-x:hidden;">
    <div class="row">
        <div class="col-lg-3">
            <!-- dashboard section -->
            <div class="row">
                <div class="card card-white pt-0">
                    <div class="card-body" style="height: 450px; max-height:450px; overflow-y: auto;">
                        <i class="fa-solid fa-list-check"></i> <b>My Task</b>
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
                        <h3 id="task_title"><i class="fa-solid fa-bars-progress"></i> </h3>
                        <input type="text" id="assignee" hidden>
                        <span><i class="fa-solid fa-ranking-star"></i> <span name="status" id="status" style="pointer-events:none;"></span></span>
                    </div>
                </div>
                <div class="row mb-0">
                    <span><b><span id="accumulated"></span></b></span>
                    <span id="desctext"></span>
                </div>
                <div class="card-body m-0" style="max-height: 370px; height:370px; overflow-y: auto;">
                    <table class="table-data text-center table table-striped">
                        <!-- ajax -->
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-4 m-0 p-0">
                        <p class="m-0 p-0" style="font-size: small;">Date Created: <i class="fa-regular fa-calendar"></i> <span style="font-size: small;" id="date_created"></span></p>
                        <p class="p-0 m-0" style="font-size: small;">Completion Date: <i class="fa-regular fa-calendar"></i> <span style="font-size: small;" id="timeline"></span></p>
                        <p class="m-0 p-0" style="font-size: small;">Assigned By: <span id="assigned_by"></span></p>
                    </div>
                    <div class="col-md-8 m-0 p-0 d-flex justify-content-end">
                        <div class="d-flex align-items-end m-0 p-0">
                            <p>Urgency: <select class="p-0 m-0" name="urgency" id="urgency" style="pointer-events:none;">
                                    <option value="0" selected></option>
                                    <option value="1">Low</option>
                                    <option value="2">Mid</option>
                                    <option value="3">High</option>
                                </select></p>
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="border:none; background-color:transparent;">
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

</div>

<?php include_once 'partials/footer.php'; ?>
<script src="js/user.js"></script>

</body>

</html>