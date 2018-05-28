@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <input type="file" id="changeAvatar" style="display: none;" accept="image/*" />
                                <img class="card-img-top avatar" src="{{ auth()->user()->avatar }}" alt="Card image cap">
                                <div class="card-body">
                                    <button type="button" class="btn btn-info btn-sm loader" onclick="document.getElementById('changeAvatar').click()" >
                                        Change Avatar
                                    </button>
                                    <button type="button" style="background-color: #4267B2; color: #FFF;" class="btn btn-default btn-sm">
                                        Share With FB
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Name: </strong>
                                        <span>{{ auth()->user()->name  }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Email: </strong>
                                        <span>{{ auth()->user()->email  }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Member Since: </strong>
                                        <span style="color: rgba(0,0,0,.3);">{{ auth()->user()->created_at  }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script>
        $(document).on('change', '#changeAvatar', function(e) {
            if(! e.target.files.length) return;
            let file = e.target.files[0]

            let reader = new FileReader();

            reader.readAsDataURL(file)

            reader.onload = e => {
                $('.avatar').attr('src', e.target.result)
            }
            onUpload(file)
        });

        function onUpload(file) {
            let data = new FormData();
            data.append('avatar', file)
            console.log(file);

            let btnLoader = $('.loader');
            btnLoader.prop('disabled', true);
            axios.post('file-upload', data, {
                onUploadProgress: uploadEvent => {
                    this.progressBar = `width: ${Math.round(uploadEvent.loaded / uploadEvent.total * 100)}%`
                    console.log('Upload Progress : '+ Math.round(uploadEvent.loaded / uploadEvent.total * 100) + '%')
                }
            }).then(() => btnLoader.prop('disabled', false))
        }
    </script>
@endsection
