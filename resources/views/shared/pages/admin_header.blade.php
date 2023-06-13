<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="" class="nav-link">iShare</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <button class="btn dropdown-toggle theme-color" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown">
                @php
                    $fullName = session()->get('session_fullname')
                @endphp
                {{ isset($fullName) ? ucwords($fullName) : '' }}&nbsp;&nbsp;<i class="far fa-user"></i>
            </button>&nbsp;&nbsp;
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                <li class="anchorProfile">
                    <a class="dropdown-item theme-color" data-bs-toggle="modal" data-bs-target="#modalEditUser"><i class="fas fa-user mr-2"></i>Profile</a>
                </li>
                <li>
                    <a class="dropdown-item theme-color" data-bs-toggle="modal" data-bs-target="#modalLogout"><i class="fa-solid fa-arrow-right mr-2"></i>Logout</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<div class="modal fade" id="modalLogout">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-info-circle"></i> Logout</h4>
                <button type="button" class="btn-close" style="margin-top: 3px;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSignOut">
                @csrf
                <div class="modal-body">
                    <p id="lblSignOut" class="mt-2 theme-color">Are you sure to logout your account?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default theme-color" data-bs-dismiss="modal">No</button>
                    <button type="button" id="btnLogout" class="btn theme-color-bg text-white"><i id="iconLogout" class="fa fa-check"></i> Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal Start -->
<div class="modal fade" id="modalEditUser" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Edit User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="formEditUser" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <!-- For User Id -->
                                <input type="text" class="form-control" style="display: none" name="user_id" id="userId" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                
                                <div class="mb-4">
                                    <p class="modal-title"><i class="fas fa-info-circle text-primary"></i>&nbsp;Note that your account needs to re-login after the update operation.</p>
                                </div>
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">First Name<span class="text-danger" title="Required">*</span></label>
                                    <input type="text" class="form-control" name="firstname" id="textFirstname" placeholder="Firstname">
                                </div>
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Last Name<span class="text-danger" title="Required">*</span></label>
                                    <input type="text" class="form-control" name="lastname" id="textLastname" placeholder="Lastname">
                                </div>
                                <div class="mb-3">
                                    <label for="middleInitial" class="form-label">Middle Initial</label>
                                    <input type="text" class="form-control" name="middle_initial" id="textMiddleInitial" placeholder="Middle Initial">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address<span class="text-danger" title="Required">*</span></label>
                                    <input type="text" class="form-control" name="email" id="textEmail" placeholder="Email Address">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Contact Number<span class="text-danger" title="Required">*</span></label>
                                    <input type="text" class="form-control" name="contact_number" id="textContactNumber" placeholder="Contact Number">
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username<span class="text-danger" title="Required">*</span></label>
                                    <input type="text" class="form-control" name="username" id="textUsername" placeholder="Username">
                                </div>
                                <div class="mb-3" id="divPassword">
                                    <label for="password" class="form-label">Password<span class="text-danger" title="Required">*</span></label>
                                    <input type="password" class="form-control" name="password" id="textPassword" placeholder="Password">
                                </div>
                                <div class="mb-3" id="divConfirmPassword">
                                    <label for="confirmPassword" class="form-label">Confirm Password<span class="text-danger" title="Required">*</span></label>
                                    <input type="password" class="form-control" name="confirm_password" id="textConfirmPassword" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btnEditUser" class="btn btn-primary"><i id="iBtnEditUserIcon" class="fa fa-check"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- Edit User Modal End -->