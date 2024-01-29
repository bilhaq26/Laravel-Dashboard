<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="my-2">
                <div class="d-inline-flex align-items-center justify-content-end w-100">
                    <div class="input-group">
                        <input wire:model.live="search" type="text" class="form-control" placeholder="Cari Pengguna . . .">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="my-1">
                <button class="btn btn-primary d-inline-flex align-item-center" data-bs-toggle="modal"
                    data-bs-target="#customer-edit_add-modal">
                    <i class="ti ti-plus f-18"></i> Add User
                </button>
            </div>
            <div class="my-2">
                <div class="tab-content">
                    <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                        <div class="row">
                            @forelse ($datas as $data)
                            <div class="col-lg-4 col-xxl-3">
                                <div class="card">
                                    <div class="card-body position-relative">
                                        <div class="position-absolute end-0 top-0 p-3">
                                            @if ($data->status == 'active')
                                            <span class="badge bg-primary">Active</span>
                                            @elseif ($data->status == 'inactive')
                                            <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </div>
                                        <div class="text-center mt-3">
                                            <div class="chat-avtar d-inline-flex mx-auto">
                                                <img class="rounded-circle img-fluid wid-70"
                                                    src="{{ asset('/storage/user/'.$data->photo) }}" alt="User image"
                                                    style="width: auto; height: 70px;">
                                            </div>
                                            <h5 class="mb-0">{{ $data->name }}</h5>
                                            <p class="text-muted text-sm">
                                                @foreach ($data->getRoleNames() as $role)
                                                {{ $role }}
                                                @endforeach
                                            </p>
                                            <div wire:ignore
                                                class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                                <i data-feather="mail"></i>&nbsp;
                                                <p class="mb-0">{{ $data->email }}</p>
                                            </div>
                                            <div wire:ignore
                                                class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                                <i data-feather="user"></i>&nbsp;
                                                <p class="mb-0">{{ $data->username }}</p>
                                            </div>
                                            <hr class="my-3 border border-secondary-subtle">

                                            <div class="row g-3" wire:ignore>
                                                <div class="col-4">
                                                    <button wire:click="edit({{ $data->id }})"
                                                        class="btn btn-primary d-inline-flex align-item-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#customer-edit_add-modal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col-4">
                                                    <button wire:click="changeStatus({{ $data->id }})" type="button"
                                                        class="btn btn-secondary">
                                                        @if ($data->status == 'active')
                                                        <i class="fas fa-toggle-on"></i>
                                                        @elseif ($data->status == 'inactive')
                                                        <i class="fas fa-toggle-off"></i>
                                                        @endif
                                                    </button>
                                                </div>
                                                <div class="col-4">
                                                    <button wire:click="destroy({{ $data->id }})" type="button"
                                                        class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </div>
                                            <hr class="my-3 border border-secondary-subtle">
                                            @if (auth()->user()->id == '1')
                                            <div wire:ignore>
                                                <button wire:click="impersonate({{ $data->id }})" type="button"
                                                    class="btn btn-info w-100">
                                                    <i class="fas fa-user-secret"></i> Impersonate
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <span>
                                <h5 class="text-center">Tidak ada data</h5>
                            </span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>


    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="customer-edit_add-modal" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="mb-0">
                        @if ($updateMode == false)
                        Tambah User
                        @elseif ($updateMode == true)
                        Edit User
                        @endif
                    </h5>
                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                        <i class="ti ti-x f-20"></i>
                    </a>
                </div>
                <form @if ($updateMode==false) wire:submit.prevent="store" @elseif ($updateMode==true)
                    wire:submit.prevent="update" @endif>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3 text-center">
                                <div class="user-upload wid-75">
                                    @if ($updateMode == false)
                                    @if ($photo == null)
                                    <img class="img-fluid wid-70 @error('photo') is-invalid @enderror"
                                        src="{{ asset('admin/images/user/avatar-5.jpg') }}" alt="User image">
                                    @elseif ($photo)
                                    <img class="img-fluid wid-70 @error('photo') is-invalid @enderror"
                                        src="{{ $photo->temporaryUrl() }}" alt="User image">
                                    @endif
                                    @elseif ($updateMode==true)
                                    @if ($photo)
                                    <img class="img-fluid wid-70 @error('photo') is-invalid @enderror"
                                        src="{{ $photo->temporaryUrl() }}" alt="User image">
                                    @else
                                    <img class="img-fluid wid-70 @error('photo') is-invalid @enderror"
                                        src="{{ asset('/storage/user/'.$prevPhoto) }}" alt="User image">
                                    @endif
                                    @endif
                                    <label for="uplfile" class="img-avtar-upload">
                                        <i class="ti ti-camera f-24 mb-1"></i>
                                        <span>Upload</span>
                                    </label>
                                    <input wire:model="photo" type="file" accept="image/png, image/jpeg" id="uplfile"
                                        class="d-none @error('photo') is-invalid @enderror">
                                    @error('photo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input wire:model="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input wire:model="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror"
                                        placeholder="Username">
                                    @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input wire:model="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Alamat</label>
                                    <textarea wire:model="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                        placeholder="Alamat"></textarea>
                                    @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nomer HP</label>
                                    <input wire:model="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" placeholder="Nomer HP">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jabatan</label>
                                    <input wire:model="jabatan" type="text"
                                        class="form-control @error('jabatan') is-invalid @enderror"
                                        placeholder="Jabatan">
                                    @error('jabatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Role</label>
                                    <select wire:model="role" class="form-select @error('role') is-invalid @enderror"
                                        aria-label="Default select example">
                                        <option>Pilih Role</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input wire:model="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input wire:model="password_confirmation" type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Konfirmasi Password">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div class="flex-grow-1 text-end">
                            <button type="button" class="btn btn-link-danger btn-pc-default"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->
</div>
