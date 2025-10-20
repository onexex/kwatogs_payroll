@extends('layout.app')
@section('content')

<!--SHAIRA-->

<div class="container-fluid">
    <div class="mb-2">
        <h4 class="text-gray-800 mb-3">Employee Roles</h4>
    </div>

   
    <div class="row pb-2">
        <div class="col-lg-4 col-md-12">
            <button class="btn btn-primary mb-2" id="btnCreateModal" data-bs-toggle="modal" data-bs-target="#mdlEmpRole">Add Employee Role</button>
        </div>
    </div>

    <div class="modal fade" id="mdlEmpRole" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Employee Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                    <div class="modal-body">
                        <form 
                            id="frmEmpScheduler"
                            method="POST"
                            action="{{ route('employee.roles.assign') }}"
                        >
                            @csrf
                            <input type="hidden" id="schedule_id">

                            <div class="mb-2">
                                <label>Employee</label>
                                <select class="form-select" id="selEmployee" name="employee_id" required>
                                    <option value="" selected disabled>Select Employee</option>
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->lname }}, {{ $emp->fname }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text employee_id_error"></span>
                            </div>

                            <div class="mb-2">
                                <label>Employee</label>
                                <select class="form-select" id="selRole" name="role_id" required>
                                    <option value="" selected disabled>Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text role_id_error"></span>
                            </div>

                            <div class="mb-2">
                                <button type="submit" id="btnSaveScheduler" class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>

     <!-- Content Row dar -->
     <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card   mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area overflow-auto">
                        <div class="table-responsive fixTableHead">
                            <table class="table table-hover table-scroll sticky">
                                <thead style="background-color: #f1f1f1; ">
                                    <tr>
                                        <th class="text-dark" scope="col">Employee</th>
                                        <th class="text-dark" scope="col">Role</th>
                                    </tr>
                                </thead>
                                <tbody id="tblAccessRights">
                                    @foreach ($users as $user)
                                        <tr>
                                            {{-- uppercase --}}
                                            <td class="text-uppercase">{{ $user->lname }}, {{ $user->fname }}</td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                    <span 
                                                        class="badge bg-primary text-uppercase role-badge"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#removeRoleModal"
                                                        data-user-id="{{ $user->id }}"
                                                        data-role-name="{{ $role->name }}"
                                                        style="cursor: pointer;"
                                                    >
                                                        {{ $role->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                        </tr>   
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Remove Role Modal -->
    <div class="modal fade" id="removeRoleModal" tabindex="-1" aria-labelledby="removeRoleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="removeRoleLabel">Remove Role</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Are you sure you want to remove the role 
            <strong id="roleNameText"></strong> 
            from this user?
        </div>
        <div class="modal-footer">
            <form id="removeRoleForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Remove</button>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const removeRoleModal = document.getElementById('removeRoleModal');
        removeRoleModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const roleName = button.getAttribute('data-role-name');

            // Update modal text
            document.getElementById('roleNameText').textContent = roleName;

            // Update form action dynamically
            const form = document.getElementById('removeRoleForm');
            form.action = `/users/${userId}/roles/${roleName}`;
        });
    });
</script>

@endsection
