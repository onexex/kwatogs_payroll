@extends('layout.app', 
    ['title' => 'Roles Permission']
)

@section('content')
    
    <div class="container-fluid">
        
        <div class="mb-2 d-sm-flex align-items-center justify-content-between">
            <h4 class=" mb-0 text-gray-800">Roles Permission : {{ $role->name }}</h4>
            <div>
                <a 
                    href="{{ route('user-roles.index') }}" 
                    class=" btn text-white" 
                    style="background-color: #008080" 
                > <i class="fa fa-arrow-left"></i> 
                    Back to Roles
                </a>
            </div>
        </div>
        <div>
            <div class="row">
                <ul class="nav nav-pills list-inline px-4" role="tablist">
                    <li class="nav-item pr-2">
                    <a
                        href="{{ route('user-roles.show', ['user_role' => $role->id, 'permission' => 'page']) }}"
                        class="nav-link text-secondary list-inline-item shadow-sm {{ $permissiontab === 'page' ? 'active' : '' }}"
                    >
                        <i class="tf-icons bx bx-user"></i> Page Permission
                    </a>
                    </li>
                </ul>
            </div>
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
                                            <th class="text-dark" scope="col">Permissions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $group)
                                            <tr class="table-primary">
                                                <td colspan="3"><strong>{{ $group['title'] }}</strong></td>
                                            </tr>

                                            @foreach($group['permissions'] as $key => $name)
                                                <tr>
                                                    <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                    <td>{{ $name }}</td>
                                                    <td class="text-center">
                                                        <label class="switch">
                                                            <input 
                                                                type="checkbox"
                                                                class="permission-checkbox"
                                                                data-role-id="{{ $role->id }}"
                                                                data-permission="{{ $key }}"
                                                                {{ $role->hasPermissionTo($key) ? 'checked' : '' }}
                                                            >
                                                            <span class="slider"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <style>
.switch {
  position: relative;
  display: inline-block;
  width: 46px;
  height: 24px;
}
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: #ccc;
  transition: .3s;
  border-radius: 24px;
}
.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .3s;
  border-radius: 50%;
}
input:checked + .slider {
  background-color: #28a745; /* green */
}
input:checked + .slider:before {
  transform: translateX(22px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', async (e) => {
            const checkboxEl = e.target;
            const roleId = checkboxEl.dataset.roleId;
            const permission = checkboxEl.dataset.permission;
            const checked = checkboxEl.checked;

            try {
                const response = await fetch(`/roles/${roleId}/permissions`, {
                    method: checked ? 'POST' : 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ permission })
                });

                if (!response.ok) {
                    throw new Error(await response.text());
                }

                console.log(`Permission "${permission}" ${checked ? 'granted' : 'revoked'} successfully`);
            } catch (err) {
                alert('Failed to update permission.');
                checkboxEl.checked = !checked; // revert on failure
            }
        });
    });
});
</script>
@endsection