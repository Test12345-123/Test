<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<div id="app">
    <div class="main-wrapper">
        <div class="main-content">
            <div class="container">
                <form method="post" action="{{ route('update-user', $user->id) }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="card mt-5">
                        <div class="card-header">
                            <h3>Edit Menu</h3>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <div class="alert-title">
                                    <h4>Whoops!</h4>
                                </div>
                                There are some problems with your input.
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" name="nama" value="{{ old('nama', $user->nama) }}" placeholder="Name" required>
                                <label for="floatingInput">Name</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="email" value="{{ old('email', $user->email) }}" placeholder="email">
                                <label for="floatingInput">Email</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPasswordConfirmation" name="password_confirmation" placeholder="Re-enter password" required>
                                <label for="floatingPasswordConfirmation">Re-enter Password</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingSelect" name="id_level" aria-label="Floating label select example" required>
                                    <option value="" disabled>Pilih Level</option>
                                    @foreach ($levels as $level)
                                    <option value="{{ $level->id }}" @if($level->id === $user->id_level) selected @endif>{{ $level->level }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingSelect">Pilih Level</label>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-outline-primary">Update</button>
                                <a href="{{ route('list-user') }}" class="btn btn-outline-danger">Kembali</a>
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