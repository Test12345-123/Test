@include('layout.head');

<body>
    @include('layout.header');
    @include('layout.sidebar');

    <main id="main" class="main">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="pagetitle">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Order</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Order</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    @if (Auth::user()->id_level == 4)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                        Add Order
                    </button>
                    @endif
                </div>
            </div>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Table Number</th>
                            <th>Total</th>
                            <th>Employee Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}</td>
                            <td>{{ $item->table->nomor_meja }}</td>
                            <td>Total: Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            <td>{{ $item->user->nama }}</td>
                            <td>
                                @if($item->status == 'Completed')
                                <span class="badge bg-success">{{ $item->status }}</span>
                                @elseif($item->status == 'Pending')
                                <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                                @else
                                {{ $item->status }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('view-order-detail', $item->id) }}" class="btn btn-secondary">
                                    <i class="fa fa-edit"></i> Detail
                                </a>
                                @if ($item->status == 'Pending' && Auth::user()->id_level == 3)
                                |
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#statusModal{{ $item->id }}">
                                    Finish
                                </button>

                                <!-- Status Modal -->
                                <div class="modal fade" id="statusModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Status Update Form</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('status-update', $item->id) }}" method="GET">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Total: Rp {{ number_format($item->total, 0, ',', '.') }}</p>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="floatingInput" name="bayar" value="" placeholder="Payment Amount" required>
                                                        <label for="floatingInput">Payment Amount</label>
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
                                <!-- end status modal -->
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>


    </main><!-- End #main -->

    <!-- Modal Add Order -->
    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Order Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('create-order') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="nama_pelanggan" value="" placeholder="Customer Name" required>
                            <label for="floatingInput">Customer Name</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" name="nomor_meja" aria-label="Floating label select example" required>
                                <option value="" selected disabled>Select Table Number</option>
                                @foreach ($table as $item)
                                @php
                                $disabled = '';
                                if ( $item->status == 'In Use') {
                                $disabled = 'disabled';
                                }
                                @endphp
                                <option value="{{ $item->id }}" {{ $disabled }}>
                                    {{ $item->nomor_meja }}
                                    @if ( $item->status == 'Reserved')
                                    <span>({{ $item->status }} by {{ $item->dipesan_oleh }})</span>
                                    @else
                                    <span>({{ $item->status }})</span>
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Tables</label>
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

    @include('layout.footer');

</body>