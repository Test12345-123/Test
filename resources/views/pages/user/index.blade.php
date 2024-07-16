@include('layout.head');

<body>
    @include('layout.header');
    @include('layout.sidebar');

    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>User</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">User</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('create-user') }}" class="btn btn-primary">Add User</a>
                </div>
            </div>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Action</th> <!-- Change the column name to Aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($item->profile_picture)
                                    <img src="{{ asset($item->profile_picture) }}" alt="{{ $item->nama }}" class="rounded-circle me-2" width="40" height="40">
                                    @endif
                                    {{ $item->nama }}
                                </div>
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->level->level }}</td>
                            <td>
                                <a href="{{ route('edit-user', $item->id) }}" class="btn btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                |
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal{{ $item->id }}">
                                    Delete
                                </button>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="basicModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Confirmation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this item?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <form action="{{ route('hapus-user', $item->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </section>


    </main><!-- End #main -->

    @include('layout.footer');



</body>

</html>