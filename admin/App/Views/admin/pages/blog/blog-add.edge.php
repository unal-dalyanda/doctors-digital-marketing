@extends('admin.master')

@section('css')
    <style>
        .tox-tinymce {
            min-height: 100vh;
            border: 0 !important;
        }

        .tagify {
            width: 100%;
            max-width: 700px;
            border-radius: .25rem;
        }
    </style>
    <link rel="stylesheet" href="{!! get_asset('admin/plugins/tagify/tagify.css', 'v=1.8.2') !!}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{!! $page_title !!}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{!! $page_title !!}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content data-table-content">
        <div class="container-fluid">
            <form action="{!! route('blog_add_action') !!}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Blog title</span>
                                        </div>
                                        <input type="text" name="title" class="form-control" aria-describedby="pageSlug"
                                               placeholder="Write your blog title here ..." required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="editor-container" class="card min-vh-100">
                            <textarea id="editor" name="content"></textarea>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">SEO Tools</h3>
                            </div>
                            <div class="card-body">
                                <div class="callout callout-info">
                                    <p>If you leave the SEO settings blank for a page or post, the general SEO settings
                                        will be applied.</p>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>SEO title <small class="text-muted">It is used as a title instead of
                                                    a blog title.</small></label>
                                            <input type="text" name="seo_title" class="form-control"
                                                   placeholder="SEO title ...">
                                        </div>
                                        <div class="form-group">
                                            <label>SEO description <small class="text-muted">If left blank, the system
                                                    will generate it automatically.</small></label>
                                            <textarea name="seo_description" class="form-control" rows="3"
                                                      placeholder="SEO description ..."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>SEO keywords <small class="text-muted">Press enter or put a comma
                                                    after each keyword.</small></label>
                                            <input name="seo_keywords" value="" placeholder="write some tags">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Publishing tools</h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Select Category</label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="" selected disabled hidden>Please select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{!! $category->ID !!}">{!! $category->category_name !!}</option>
                                        @endforeach
                                        <option value="0">Uncategorized</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" name="submit" value="draft" class="btn btn-default">Save to
                                    draft
                                </button>
                                <button type="submit" name="submit" value="publish" class="btn btn-primary float-right">
                                    Publish
                                </button>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Image tools</h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputFile">Featured image</label>

                                    <div class="mb-2">
                                        <img src="" class="img-fluid img-thumbnail d-none" id="preview"/>
                                    </div>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="cover_image" class="custom-file-input"
                                                   id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Select image</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script
        src="{!! get_asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js', 'v=1.8.2') !!}"></script>
    <script src="/vendor/tinymce/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{!! get_asset('admin/plugins/tagify/jQuery.tagify.min.js', 'v=1.8.2') !!}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();

            $("#exampleInputFile").on('change', function () {
                var input = $(this)[0];
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = $("#preview");
                        preview.attr('src', e.target.result).fadeIn('slow');
                        preview[0].classList.remove("d-none");
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            })
        });
    </script>
    <script>
        var el = document.createElement('div');
        document.body.appendChild(el);

        tinymce.PluginManager.add('systemgallery', function(editor, url) {
            var openDialog = function () {
                return editor.windowManager.openUrl({
                    title: 'Image Gallery',
                    icon: 'gallery',
                    size: 'large',
                    url: '{!! route('image_gallery') !!}'

                    /*
                    * let element = document.querySelectorAll('.tox-dialog__body-nav-item')[1];
        if (element) { element.click() }*/
                });
            };

            editor.ui.registry.addButton('systemgallery', {
                text: 'Image Gallery',
                icon: 'gallery',
                onAction: function () {
                    /* Open window */
                    openDialog();
                }
            });
        });

        const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{!! route('image_upload') !!}');

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                const json = JSON.parse(xhr.responseText);

                if (xhr.status === 400) {
                    reject({ message: json.message, remove: true });
                    return;
                }

                if (xhr.status === 403) {
                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                    return;
                }

                if (xhr.status === 500) {
                    reject({ message: json.message, remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        });

        tinymce.init({
            selector: 'textarea#editor',
            plugins: 'image code lists link table importcss systemgallery',
            image_title: true,
            images_reuse_filename: true,
            automatic_uploads: true,
            file_picker_types: 'image',
            images_file_types: 'jpg,png,webp',
            images_upload_url: '{!! route('image_upload') !!}',
            menu: {
                file: {title: 'File', items: ''},
                edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall | searchreplace'},
                view: {
                    title: 'View',
                    items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen | showcomments'
                },
                insert: {
                    title: 'Insert',
                    items: 'image link media addcomment pageembed template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor tableofcontents | insertdatetime'
                },
                format: {
                    title: 'Format',
                    items: 'bold italic underline strikethrough superscript subscript codeformat | styles blocks fontsize align lineheight | forecolor backcolor | language | removeformat'
                },
                table: {title: 'Table', items: 'inserttable | cell row column | advtablesort | tableprops deletetable'},
                help: {title: 'Help', items: 'help'}
            },
            toolbar: "undo redo | bold italic | styles formatselect forecolor | alignleft aligncenter alignright alignjustify | bullist numlist checklist outdent indent | link systemgallery",
            content_css: '{{ PUBLIC_DIR }}northisland/css/style.css',
            importcss_append: true,
            promotion: false,
            branding: false,
            /*
            setup: function(editor) {
                editor.on('ExecCommand', (event) => {
                    console.log('ExecCommand Init');
                    const command = event.command;
                    if (command === 'mceImage') {
                        const tabElems = document.querySelectorAll('.tox-dialog div[role="tablist"] .tox-tab');
                        console.log(tabElems);
                        tabElems.forEach(tabElem => {
                            console.log(tabElem);
                        });
                    }
                });
            },*/
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function () {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        cb(blobInfo.blobUri(), {title: file.name});
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },
            images_upload_handler: example_image_upload_handler
        });

        var input = document.querySelector('input[name=seo_keywords]');
        new Tagify(input);
    </script>

@endsection
