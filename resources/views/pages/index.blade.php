@include('layout.head');

<body>
  @include('layout.header');
  @include('layout.sidebar');

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <div class="row">

        @if (Auth::user()->id_level == 2)
          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

              <div class="card-body">
                <h5 class="card-title">Sales <span>| Today</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $todaySold }}</h6>
                    <span class="small pt-1 fw-bold {{ $difference >= 0 ? 'text-success' : 'text-danger' }}">
                      {{ abs($difference) }} Item
                    </span>
                    <span class="text-muted small pt-2 ps-1">
                      {{ $difference >= 0 ? 'increase' : 'decrease' }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Sales Card -->
          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

              <div class="card-body">
                <h5 class="card-title">Sales <span>| This Month</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $thisMonthSold }}</h6>
                    <span class="small pt-1 fw-bold {{ $differenceLastMonth >= 0 ? 'text-success' : 'text-danger' }}">
                      {{ abs($differenceLastMonth) }} Item
                    </span>
                    <span class="text-muted small pt-2 ps-1">
                      {{ $differenceLastMonth >= 0 ? 'increase' : 'decrease' }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Sales Card -->

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
              <div class="card-body">
                <h5 class="card-title">Revenue <span>| Today</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ 'Rp '.number_format($todayRevenue, 0, ',', '.') }}</h6>
                    <span class="small pt-1 fw-bold {{ $revenueDifferenceToday >= 0 ? 'text-success' : 'text-danger' }}">
                      {{ 'Rp '.number_format(abs($revenueDifferenceToday), 0, ',', '.') }}
                    </span>
                    <span class="text-muted small pt-2 ps-1">
                      {{ $revenueDifferenceToday >= 0 ? 'increase' : 'decrease' }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Revenue Card -->

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
              <div class="card-body">
                <h5 class="card-title">Revenue <span>| This Month</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ 'Rp '.number_format($thisMonthRevenue, 0, ',', '.') }}</h6>
                    <span class="small pt-1 fw-bold {{ $revenueDifferenceThisMonth >= 0 ? 'text-success' : 'text-danger' }}">
                      {{ 'Rp '.number_format(abs($revenueDifferenceThisMonth), 0, ',', '.') }}
                    </span>
                    <span class="text-muted small pt-2 ps-1">
                      {{ $revenueDifferenceThisMonth >= 0 ? 'increase' : 'decrease' }}
                    </span>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->

          <!-- Customers Card -->
          <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card">
              <div class="card-body">
                <h5 class="card-title">Orders <span>| Today</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $todayOrders }}</h6>
                    <span class="small pt-1 fw-bold {{ $orderDifferenceToday >= 0 ? 'text-success' : 'text-danger' }}">
                      {{ abs($orderDifferenceToday) }} Item
                    </span>
                    <span class="text-muted small pt-2 ps-1">
                      {{ $orderDifferenceToday >= 0 ? 'increase' : 'decrease' }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Customers Card -->

          <!-- Customers Card -->
          <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card">
              <div class="card-body">
                <h5 class="card-title">Orders <span>| This Month</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $thisMonthOrders }}</h6>
                    <span class="small pt-1 fw-bold {{ $orderDifferenceThisMonth >= 0 ? 'text-success' : 'text-danger' }}">
                      {{ abs($orderDifferenceThisMonth) }} Item
                    </span>
                    <span class="text-muted small pt-2 ps-1">
                      {{ $orderDifferenceThisMonth >= 0 ? 'increase' : 'decrease' }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Customers Card -->
          @endif

          <!-- Recent Activity -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Recent Activity</h5>

              <div class="activity">
                @foreach($logActivities as $logActivity)
                <div class="activity-item d-flex">
                  <div class="activite-label">{{ $logActivity->created_at->diffForHumans() }}</div>
                  <i class='bi bi-circle-fill activity-badge {{ $logActivity->getTypeColor() }} align-self-start'></i>
                  <div class="activity-content">
                    {{ $logActivity->user->nama }} has {{ $logActivity->activity }}
                  </div>
                </div><!-- End activity item-->
                @endforeach
              </div>
            </div>
          </div><!-- End Recent Activity -->
        </div>
      </div>
    </section>


  </main><!-- End #main -->

  @include('layout.footer');

</body>

</html>