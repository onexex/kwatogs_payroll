@extends('layout.app', 
    ['title' => 'User Roles']
)

@section('content')
    <div class="container-fluid">
        
        <div class="mb-2 d-sm-flex align-items-center justify-content-between">
            <h4 class=" mb-0 text-gray-800">User Roles</h4>
            <button 
                class=" mt-3 btn text-white" 
                style="background-color: #008080" 
                name="createUserRole" 
                id="createUserRole" 
                data-bs-toggle="modal" 
                data-bs-target="#createUserRoleModal"
            > <i class="fa fa-plus"></i> 
                Add User Role
            </button>
        </div>

        <div class="row mt-2">
            <div class="col-xl-12 col-lg-12">
                <div class="card mb-4">
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <div class="table-responsive border-0">
                                <table class="table table-hover table-border-none  ">
                                    <thead>
                                        <tr>
                                            <th class="text-dark" scope="col">No</th>
                                            <th class="text-dark" scope="col">Roles</th>
                                            <th class="text-dark" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-light editRoleBtn" 
                                                    data-id="{{ $role->id }}" 
                                                    data-name="{{ $role->name }}" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editRoleBtnModal{{ $role->id }}"
                                                >
                                                    <i class="fa fa-edit text-primary"></i>
                                                    Edit
                                                </button>
                                                <a 
                                                    href="{{ route('user-roles.show', $role->id) }}" 
                                                    class="btn btn-sm btn-light"
                                                >
                                                    <i class="fa fa-eye text-success"></i>
                                                    View Permission
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Edit Role Modal -->
                                        <div class="modal fade" id="editRoleBtnModal{{ $role->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editRoleBtnModalLabel{{ $role->id }}" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info dragable_touch" >
                                                        <h5 class="modal-title fst-italic text-white" id="staticBackdropLabel"><label for="" class="" id="lblTitleOBT"> Edit Role Form</label></h5>
                                                        <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card mb-3 ">
                                                            <div class="card-body ">

                                                                <form 
                                                                    method="POST" 
                                                                    action="{{ route('user-roles.update', $role->id) }}" 
                                                                    id="frmEditRoles{{ $role->id }}" 
                                                                >
                                                                    @csrf 
                                                                    @method('PUT')
                                                                    <div class="row">
                                                                        <div class="col-lg-12 mb-2">
                                                                            <div class="form-floating">
                                                                                <input class="form-control" id="txtEditRole{{ $role->id }}" required name="role" type="text" placeholder="-" value="{{ $role->name }}" />
                                                                                <label class="form-check-label" for="txtEditRole{{ $role->id }}">Role Name <label for="" class="text-danger">*</label></label>
                                                                                <span class="text-danger small error-text role_error"></span>       
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button  id="btnUpdateRole{{ $role->id }}" type="submit" class="btn btn-secondary ">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <div class="modal fade" id="createUserRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createUserRoleModal" aria-hidden="true" style="background-color: rgb(249 200 200 / 17%);">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info dragable_touch" >
                    <h5 class="modal-title fst-italic text-white" id="staticBackdropLabel"><label for="" class="" id="lblTitleOBT"> Create Role Form</label></h5>
                    <button type="button" class="btn-close text-white closereset_update" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3 ">
                        <div class="card-body ">

                            <form 
                                method="POST" 
                                action="{{ route('user-roles.store') }}" 
                                id="frmRoles" 
                            >
                                @csrf 
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-floating">
                                            <input class="form-control" id="txtRole" required name="role" type="text" placeholder="-" />
                                            <label class="form-check-label" for="txtRole">Role Name <label for="" class="text-danger">*</label></label>
                                            <span class="text-danger small error-text role_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-secondary closereset_update" data-bs-dismiss="modal">Close</button> -->
                                    <button  id="btnSaveOBT" type="submit" class="btn btn-secondary ">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection