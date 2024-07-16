@extends('layout.head')

<!-- Include your layout header -->
<div class="content">
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-3 text-primary">Order Detail</h1>
        <p class="mb-1"><strong>Order ID:</strong> {{ $order->id }}</p>
        <p class="mb-1"><strong>Employee Name:</strong> {{ $order->user->nama }}</p>
        <p class="mb-1"><strong>Customer Name:</strong> {{ $order->nama_pelanggan }}</p>
        <p class="mb-1"><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</p>
        <p class="mb-5"><strong>Table Number:</strong> {{ $order->table->nomor_meja }}</p>

        <div class="row">
            <!-- Menampilkan daftar menu -->
            <div class="col-lg-8">
                <div class="row">
                    @foreach($menus as $menu)
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card border">
                            <img src="{{ asset($menu->image) }}" class="card-img-top" alt="{{ $menu->nama_menu }}" style="max-height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $menu->nama_menu }}</h5>
                                <p class="card-text">Price: Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                <form action="{{ route('submit-order', ['id' => $order->id]) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                    <div class="mb-3">
                                        <label for="qty" class="form-label">Quantity</label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" onclick="decrementValue('{{ $menu->id }}')">-</button>
                                            <input type="number" class="form-control text-center" id="itemQuantity_{{ $menu->id }}" name="qty" value="{{ $order->menus->find($menu->id)->pivot->qty ?? 0 }}" min="0">
                                            <button class="btn btn-outline-secondary" type="button" onclick="incrementValue('{{ $menu->id }}')">+</button>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-outline-primary">Order</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>


            <!-- Cart Summary Card -->
            <div class="col-lg-4">
                <div class="card text-center mx-auto">
                    <div class="card-body">
                        <h3 class="mb-2 mt-2">Order Details</h3>
                        <ul class="list-group">
                            @foreach($detailOrders as $detailOrder)
                            <li class="list-group-item d-flex flex-column mb-3">
                                <div class="d-flex justify-content-center mb-2">
                                    <strong>{{ $detailOrder->menu->nama_menu }}</strong>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <span class="badge bg-primary rounded-pill">Qty: {{ $detailOrder->qty }}</span>
                                    <span class="badge bg-success rounded-pill ms-2">
                                        Total: Rp {{ number_format($detailOrder->menu->harga * $detailOrder->qty, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <button type="button" class="btn btn-outline-danger rounded-pill btn-sm" data-bs-toggle="modal" data-bs-target="#basicModal{{ $detailOrder->id }}">Delete</button>

                                    <!-- Basic Modal -->
                                    <div class="modal fade" id="basicModal{{ $detailOrder->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Confirmation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this item?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <!-- Form for Delete Action -->
                                                    @if(isset($detailOrder))
                                                    <form action="{{ route('delete-menu', ['order_id' => $order->id, 'menu_id' => $detailOrder->menu->id]) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                    </form>
                                                    @else
                                                    <!-- Tindakan atau tampilan yang sesuai ketika $detailOrder tidak terdefinisi -->
                                                    <p>No detail order available.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Basic Modal-->

                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <h3 class="mt-4 mb-2 text-center">Total: Rp {{ number_format($order->detailOrders->sum(function ($detailOrder) { return $detailOrder->menu->harga * $detailOrder->qty; }), 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="card-footer mt-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('order') }}" class="btn btn-outline-primary">Done</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@include('layout.footer')