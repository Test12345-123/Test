@include('layout.head');

<body>
    @include('layout.header');
    @include('layout.sidebar');

    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Menu</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Menu</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('create-table') }}" class="btn btn-primary">Add Table</a>
                </div>
            </div>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Table Number</th>
                            <th>Status</th>
                            <th>Reserved By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($table as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{$item->nomor_meja}}</td>
                            <td>
                                @if($item->status == 'Available')
                                <span class="badge bg-success">{{ $item->status }}</span>
                                @elseif($item->status == 'Reserved')
                                <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                                @elseif($item->status == 'In Use')
                                <span class="badge bg-danger text-dark">{{ $item->status }}</span>
                                @else
                                {{ $item->status }}
                                @endif
                            </td>
                            <td>
                                @if($item->dipesan_oleh == null)
                                Unreserved
                                @else
                                {{$item->dipesan_oleh}}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('edit-table', $item->id) }}" class="btn btn-warning">
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
                                                <form action="{{ route('hapus-table', $item->id) }}" method="POST" style="display: inline;">
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
                                <!-- End Modal Hapus -->

                                @if ($item->status == 'Available')
                                |
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reservedModal{{ $item->id }}">
                                    Reservation
                                </button>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="reservedModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Reservation Form</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('reserve-table', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">

                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="floatingInput" name="nama_pemesan" value="" placeholder="Orderer's Name" required>
                                                        <label for="floatingInput">Orderer's Name</label>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-check"></i> Submit
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @elseif ($item -> status == 'Reserved')
                                |
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $item->id }}">
                                    Cancel
                                </button>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="cancelModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cancel Confirmation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to Cancel this reservation?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <form action="{{ route('cancel-reservation', $item->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal Hapus -->
                                @endif
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