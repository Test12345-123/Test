<!doctype html>
<html lang="en">
@include('layout.head')
  <body>
    <div id="app">
      <div class="main-wrapper">
        <div class="main-content">
          <div class="container">
            <form method="post" action="{{ route('store-table') }}" enctype="multipart/form-data">
              @csrf
              <div class="card mt-5">
                <div class="card-header">
                  <h3>Add Menu</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                      <div class="alert alert-danger">
                        <div class="alert-title"><h4>Whoops!</h4></div>
                          There are some problems with your input.
                          <ul>
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                          </ul>
                      </div> 
                    @endif

                    @if (session('success'))
                      <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput" name="table" placeholder="Table Number">
                      <label for="floatingInput">Table Number</label>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-outline-primary">Buat</button>
                        <a href="{{ route('list-table') }}" class="btn btn-outline-danger">Kembali</a>
                    </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
  @include('layout.footer');
</html>