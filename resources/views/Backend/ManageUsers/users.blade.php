@extends('backend.layouts.main')

@section('title', 'Management')

@section('content')
    <div class="container py-3 col-12">

        <div class="main-card mb-3 card">
            <div class="card-header bg-color text-white d-flex justify-content-between">
                <h5 class="mb-0 text-white">User Management</h5>

                <a href="{{ route('superadmin.users.index', ['type' => 'user']) }}" class="btn btn-light">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </a>
            </div>
            <div class="card-body">
                <!-- Breadcrumb Navigation -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 py-3">
                        <li class="breadcrumb-item">
                            @if (Auth::user()->role->role_name == 'Super Admin')
                                <a href="{{ route('super.admin.dashboard') }}">Dashboard</a>
                            @elseif(Auth::user()->role->role_name == 'Admin')
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            @endif
                        </li>
                        <li class="breadcrumb-item ">
                            User Management
                        </li>
                        <li class="breadcrumb-item text-primary active fw-bold" aria-current="page">
                            @if ($type === 'user')
                                Users Lists
                            @elseif($type === 'Super Admin')
                                Super Admin Lists
                            @elseif($type === 'admin')
                                Interacted User Lists
                            @endif
                        </li>
                    </ol>
                </nav>

                <!-- Search Input -->
                <div class="mb-3">
                    <input type="search" id="search" class="form-control" placeholder="Search by name"
                        autocomplete="off">
                </div>
                <!-- Results Table -->
                <div class="table-responsive">
                    <table class="table table-striped" id="userTable">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Profile Picture</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                @if (Auth::user()->role->role_name == 'Super Admin')
                                    <th>Action</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            @if ($users->count() > 0)
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ $user->avatar ? (filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset('storage/' . $user->avatar)) : asset('frontend/assets/images/profile.avif') }}"
                                                class="rounded-circle" style="width:60px; height:60px;" />
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>

                                        <td>{{ $user->phone ? $user->phone : 'N/A' }}</td>

                                        <td>
                                            <span class="badge bg-label-{{ $user->status == 1 ? 'success' : 'danger' }}">
                                                {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        @if (Auth::user()->role->role_name == 'Super Admin')
                                            <td>
                                                <div class="col-lg-3 col-sm-6 col-12">
                                                    <div class="demo-inline-spacing">
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow btn-sm"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-small">
                                                                <button class="btn btn-primary btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#updateRoleModal{{ $user->id }}">
                                                                    Update Role
                                                                </button>
                                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                                    data-bs-target="#deleteUserModal"
                                                                    onclick="setDeleteUserModal({{ $user->id }}, '{{ $user->name }}')">
                                                                    Delete
                                                                </button>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif

                                    </tr>

                                    <!-- Modal for Updating Role -->
                                    <div class="modal fade" id="updateRoleModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="updateRoleModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('superadmin.users.updateRole', $user->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="updateRoleModalLabel{{ $user->id }}">Update Role</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Update role for <strong>{{ $user->name }}</strong>:</p>
                                                        <div class="form-group">
                                                            <label for="role">Select Role</label>
                                                            <select id="role" name="role" class="form-control">
                                                                @foreach ($all_roles as $role)
                                                                    <option value="{{ $role->id }}"
                                                                        {{ $role->id == $user->role_id ? 'selected' : '' }}>
                                                                        {{ $role->role_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Role</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No users found.</td>
                                </tr>
                            @endif
                        </tbody>

                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="mt-3" id="paginationLinks">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>



    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteUserForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete permanently <strong id="deleteUserName"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Role Modal -->
    <!-- Update Role Modal -->
    <div class="modal fade" id="updateRoleModal" tabindex="-1" aria-labelledby="updateRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateRoleModalLabel">Update Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role">Select Role</label>
                            <select name="role" id="role" class="form-control">
                                @foreach ($all_roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function setDeleteUserModal(userId, userName) {
            // Use route() to generate the URL dynamically
            document.getElementById('deleteUserForm').action = "{{ route('superadmin.users.destroy', ':user') }}".replace(
                ':user', userId);
            document.getElementById('deleteUserName').textContent = userName;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <script>
        $(document).ready(function() {

            function showToast(type, message, title = 'Notification') {
                const toast = $('#toastMessage'); // Get the toast container
                toast.removeClass('bg-success bg-danger').addClass(`bg-${type}`);
                $('#toastBody').text(message);
                toast.fadeIn().show();
                setTimeout(function() {
                    toast.fadeOut();
                }, 5000);
            }

            function showSuccessToast(message) {
                showToast('success', message, 'Success');
            }

            function showErrorToast(message) {
                showToast('danger', message, 'Error');
            }

            const userTableBody = $('#userTableBody');
            const paginationLinks = $('#paginationLinks');

            // Search keyup listener
            $('#search').on('keyup', function() {
                const query = $(this).val().trim();
                const type = '{{ $type }}'; // Use dynamic type from Blade

                if (query === '') {
                    // Redirect to the main user index page
                    window.location.href = "{{ route('superadmin.users.index', ['type' => ':type']) }}"
                        .replace(':type', type);
                } else {
                    // Fetch filtered users via AJAX
                    fetchUsers(query, type);
                }
            });

            // Fetch filtered users
            function fetchUsers(query, type) {
                const url = `{{ route('superadmin.users.search', ['type' => ':type']) }}`.replace(':type', type) +
                    `?query=${query}`;

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        updateUserTable(data.users || []);
                        updatePaginationLinks(data.pagination || '');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching users:', xhr.responseText || error);
                    },
                });
            }

            // Dynamically update the user table
            function updateUserTable(users) {
                let rows = '';

                if (users.length > 0) {
                    users.forEach((user, index) => {
                        rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            <img src="${getAvatarUrl(user.avatar)}" class="rounded-circle" style="width:60px; height:60px;">
                        </td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.phone || 'N/A'}</td>
                        <td>
                            <span class="badge bg-label-${user.status === 1 ? 'success' : 'danger'}">
                                ${user.status === 1 ? 'Active' : 'Inactive'}
                            </span>
                        </td>
                        <td>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="demo-inline-spacing">
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow btn-sm"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-small">
                                            <button class="btn btn-primary btn-sm" 
                data-bs-toggle="modal" 
                data-bs-target="#updateRoleModal" 
                onclick="setUserRoleModal(${user.id}, '${user.name}', ${user.role_id})">
                Update Role
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteUserModal"
                                                onclick="setDeleteUserModal(${user.id}, '${user.name}')">
                                                Delete
                                            </button>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>`;
                    });
                } else {
                    rows = `
                <tr>
                    <td colspan="6" class="text-center">No users found.</td>
                </tr>`;
                }

                userTableBody.html(rows);
            }

            // Update pagination links dynamically
            function updatePaginationLinks(pagination) {
                paginationLinks.html(pagination || '');
            }

            // Generate avatar URL (local or remote)
            function getAvatarUrl(avatar) {
                if (avatar) {
                    const isUrl = avatar.startsWith('http') || avatar.startsWith('https');
                    return isUrl ? avatar : `{{ asset('storage/') }}/${avatar}`;
                }
                return `{{ asset('frontend/assets/images/default-thumbnail.png') }}`;
            }

            // Set up the Update Role Modal dynamically
            window.setUserRoleModal = function(userId, userName, roleId) {
                const modal = $('#updateRoleModal');

                // Update modal title
                modal.find('.modal-title').text(`Update Role for ${userName}`);

                // Set the user ID as a data attribute
                modal.find('form').attr('data-user-id', userId);

                // Select the current role dynamically
                modal.find('#role').val(roleId).trigger('change'); // Ensure the select displays correctly
            };


            // Submit the role update form via AJAX
            $('#updateRoleModal form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                const form = $(this);
                const userId = form.data('user-id'); // Get the user ID from the data attribute

                // Dynamically generate the URL with user_id
                const url = `{{ route('superadmin.users.updateRole', ':id') }}`.replace(':id', userId);

                // Log the URL for debugging
                console.log(url);

                const role = form.find('#role').val(); // Get the selected role

                $.ajax({
                    url: url,
                    type: 'PATCH', // Use PATCH as per the route definition
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        role: role,
                        user_id: userId, // Pass user ID explicitly
                    },
                    success: function(response) {
                        $('#updateRoleModal').modal('hide'); // Hide the modal
                        fetchUsers($('#search').val(),
                            '{{ $type }}'); // Refresh the user list
                        showSuccessToast(response.message || 'Role updated successfully');
                    },
                    error: function(response, xhr, status, error) {

                        showErrorToast(response.message ||
                            'Failed to update role. Please try again.');

                    }
                });
            });

            // Ensure the modal is cleaned up when closed
            $('#updateRoleModal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $(this).find('form').removeAttr('data-user-id'); // Remove the user ID
            });
        });
    </script>
@endsection
