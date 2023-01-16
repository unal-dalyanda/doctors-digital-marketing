@extends('admin.loader')

@section('content')
    <nav class="main-header navbar navbar-expand navbar-fixed-top navbar-white navbar-light">
        <ul class="navbar-nav">
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="btn btn-outline-success" onclick="uploadBtn()" role="button">
                    <i class="fa fa-upload"></i> Upload New Image
                </a>
            </li>
        </ul>
    </nav>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="row">
                            @foreach($images as $index=>$image)
                                <div class="col-xl-2 col-lg-3 col-sm-4">
                                    <div class="file-man-box rounded mt-3 img-check">
                                        <a href="#" class="file-close">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </a>
                                        <div class="file-img-box">
                                            <img src="{!! get_asset('uploads' . $image['path']) !!}" alt="icon">
                                        </div>
                                        <div class="file-man-title">
                                            <h5 class="mb-0 text-overflow">{{$image['name']}}</h5>
                                            <p class="mb-0"><small>{{$image['size']}}</small></p>
                                        </div>
                                        <input type="radio" name="imageCheck" id="radio-{!! $index !!}" value="{!! get_asset('uploads/' . $image['path']) !!}" autocomplete="off">
                                        <label for="radio-{!! $index !!}">Archived</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div><!-- end col -->
            </div>
        </div>
    </section>

    <nav class="main-header navbar fixed-bottom navbar-expand navbar-fixed-top navbar-white navbar-light">
        <ul class="navbar-nav">
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link btn btn-light" onclick="closeBtn()" role="button">
                    Cancel
                </a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary nav-link" onclick="clickSub()" role="button">
                    Import image to editor
                </a>
            </li>
        </ul>
    </nav>
@endsection

@section('js')
    <script>
        $(document).ready(function(e){
            $(".img-check").click(function(){
                if($(this).first().find('input[name="imageCheck"]')[0].checked === true){
                    $(this).first().find('input[name="imageCheck"]')[0].checked = false;
                }else{
                    $(this).first().find('input[name="imageCheck"]')[0].checked = true;
                }
            });
        });

        function uploadBtn()
        {
            console.log('uploadBTN');

            window.parent.postMessage({
                mceAction: 'execCommand',
                cmd: 'mceImage'
            }, origin);

            window.parent.postMessage({
                mceAction: 'close'
            }, origin);
        }

        function clickSub() {
            var value = $('input[name=imageCheck]:checked').val();

            window.parent.postMessage({
                mceAction: 'insertContent',
                content: '<img src="'+value+'">',
            }, origin);

            window.parent.postMessage({
                mceAction: 'close'
            }, origin);
        }

        function closeBtn()
        {
            window.parent.postMessage({
                mceAction: 'close'
            }, origin);
        }
    </script>
@endsection
