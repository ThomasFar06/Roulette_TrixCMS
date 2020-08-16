<div class="row">
    <div class="col-12">
        <div id="alert-container">
        </div>
    </div>
</div>

<div class="row">
    @if(user()->hasPermission('DASHBOARD_ROULETTE_CONFIGURE|admin'))
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __("roulette_arckene::admin.Configuration.title") }}</h6>
                </div>
                <div class="card-body">
                    <form method="post" id="setup-configuration">
                        <div class="form-group">
                            <label for="elements">{!! __("roulette_arckene::admin.Configuration.labelElements") !!}</label>
                            <input type="number" step="1" min="0" class="form-control" id="elements" name="elements"
                                   placeholder="{{ __("roulette_arckene::admin.Configuration.labelElements") }}"
                                   value="{{ $rconfig['elements'] }}">
                        </div>
                        <div class="form-group">
                            <label for="price">{{ __("roulette_arckene::admin.Configuration.labelPrice") }}</label>
                            <input type="number" step="10" min="0" class="form-control" id="price" name="price"
                                   placeholder="{{ __("roulette_arckene::admin.Configuration.labelPrice") }}"
                                   value="{{ $rconfig['price'] }}">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success btn-block"
                                    id="btn-setup-configuration">{{ __("roulette_arckene::admin.Global.save") }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __("roulette_arckene::admin.Adding.title") }}</h6>
                </div>
                <div class="card-body">
                    <form method="post" id="add-element">
                        <div class="form-group">
                            <label for="type">{{ __("roulette_arckene::admin.Global.labelType") }}</label>
                            <select name="type" id="type" class="form-control">
                                <option value="1">{!! __("roulette_arckene::admin.Global.optionType1") !!}</option>
                                <option value="2">{!! __("roulette_arckene::admin.Global.optionType2") !!}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="number">{{ __("roulette_arckene::admin.Global.labelNumber") }}</label>
                            <input type="number" step="1" min="0" class="form-control" id="number" name="number"
                                   placeholder="{{ __("roulette_arckene::admin.Global.labelNumber") }}">
                        </div>
                        <div class="form-group">
                            <label for="title">{{ __("roulette_arckene::admin.Global.labelTitle") }}</label>
                            <input type="text" maxlength="20" class="form-control" id="title" name="title"
                                   placeholder="{{ __("roulette_arckene::admin.Global.labelTitle") }}">
                        </div>
                        <div class="form-group">
                            <label for="color">{{ __("roulette_arckene::admin.Global.labelColor") }}</label>

                            <label class='color-picker'>
                                <input class='color' type='color' id="color" value="#dddddd" tabindex='-1'/>
                                <input class='hex' type='text' id="text" value="#dddddd" onfocus="this.select()"/>
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success btn-block"
                                    id="btn-add-element">{{ __("roulette_arckene::admin.Global.add") }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="col-md-8">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h4 class="m-0 font-weight-bold text-primary">Les prix</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable-prices" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __("roulette_arckene::admin.Global.labelType") }}</th>
                                <th>{{ __("roulette_arckene::admin.Global.labelNumber") }}</th>
                                <th>{{ __("roulette_arckene::admin.Global.labelTitle") }}</th>
                                <th>{{ __("roulette_arckene::admin.Global.labelColor") }}</th>
                                <th>{{ __("roulette_arckene::admin.Global.labelAction") }}</th>
                            </tr>
                            </thead>
                            <tbody class="vcenter">
                            @if($relements->count())
                                @foreach($relements as $r)
                                    <tr>
                                        <td>{{$r['id']}}</td>
                                        <td>
                                            {!! __("roulette_arckene::admin.Global.optionType".$r['type']) !!}
                                        </td>
                                        <td>{{$r['title']}}</td>
                                        <td>{{$r['number']}}</td>
                                        <td>{{$r['color']}}</td>
                                        <td nowrap>
                                            <button type="button" class="btn btn-success"
                                                    onclick="editElement({{ $r['id'] }}, '{{ $r['type'] }}', '{{ $r['number'] }}', '{{ $r['title'] }}', '{{ $r['color'] }}')">
                                                <i class="fas fa-edit"></i> {{ __("roulette_arckene::admin.Global.edit") }}
                                            </button>
                                            <button type="button" class="btn btn-danger"
                                                    onclick="deleteElement({{ $r['id'] }})"><i
                                                        class="fas fa-trash"></i> {{ __("roulette_arckene::admin.Global.delete") }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>


    function editElement(id, type, number, title, color) {
        const modal = $('#editElemModal');
        modal.find("#mid").attr('value', id);
        modal.find("#mtype").attr('value', type);
        modal.find("#mnumber").attr('value', number);
        modal.find("#mtitle").attr('value', title);
        modal.find("#mcolor").attr('value', color);
        modal.find("#mtext").attr('value', color);

        modal.modal('show');
    }


</script>

<div class="modal fade" id="editElemModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __("roulette_arckene::admin.Edit.title") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="edit-element" method="post">

                <div class="modal-body">
                    <div id="alert-modal"></div>
                    <input type="hidden" id="mid" name="id">
                    <div class="form-group">
                        <label for="type">{{ __("roulette_arckene::admin.Global.labelType") }}</label>
                        <select name="type" id="mtype" class="form-control shadow card">
                            <option value="1">{!! __("roulette_arckene::admin.Global.optionType1") !!}</option>
                            <option value="2">{!! __("roulette_arckene::admin.Global.optionType2") !!}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="number">{{ __("roulette_arckene::admin.Global.labelNumber") }}</label>
                        <input type="number" step="1" min="0" class="form-control shadow card" id="mnumber"
                               name="number" placeholder="{{ __("roulette_arckene::admin.Global.labelNumber") }}">
                    </div>
                    <div class="form-group">
                        <label for="title">{{ __("roulette_arckene::admin.Global.labelTitle") }}</label>
                        <input type="text" maxlength="20" class="form-control shadow card" id="mtitle" name="title"
                               placeholder="{{ __("roulette_arckene::admin.Global.labelTitle") }}">
                    </div>
                    <div class="form-group">
                        <label for="color">{{ __("roulette_arckene::admin.Global.labelColor") }}</label>

                        <label class='color-picker'>
                            <input class='color' type='color' id="mcolor" value="#dddddd" tabindex='-1'/>
                            <input class='hex' type='text' id="mtext" value="#dddddd" onfocus="this.select()"/>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __("roulette_arckene::admin.Global.cancel") }}</button>
                    <button type="button" class="btn btn-primary btn-saved"
                            id="btn-edit-element">{{ __("roulette_arckene::admin.Global.save") }}</button>
                </div>
            </form>
        </div>
    </div>
</div>


@if(user()->hasPermission('DASHBOARD_ROULETTE_CONFIGURE|admin'))
    <script>
        $(document).ready(function () {
            $('#datatable-prices').DataTable({
                "language": {
                    "url": "{{ action('Controller@datatable_lang') }}"
                }
            });
        });

        $('#btn-setup-configuration').on('click', () => {
            $("#btn-setup-configuration").prop('disabled', true);

            $.ajax({
                url: '{{route('admin.roulette.configure')}}',
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                },
                data: 'elem=' + $('#elements').val() + '&price=' + $('#price').val(),
                success: (data) => {
                    $("#alert-container").html('<div class="alert alert-' + data.type + '" id="roulette-alert">' +
                        data.message +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>');

                    $('#setup-configuration input').removeClass("is-invalid");
                    $("#btn-setup-configuration").prop('disabled', false);
                }
            });
        });

        $('#btn-add-element').on('click', () => {
            $("#btn-add-element").prop('disabled', true);

            $.ajax({
                url: '{{route('admin.roulette.add')}}',
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                },
                data: 'type=' + $('#type').val() + '&number=' + $('#number').val() + '&title=' + $('#title').val() + '&color=' + $('#color').val(),
                success: (data) => {
                    $("#alert-container").html('<div class="alert alert-' + data.type + '" id="roulette-alert">' +
                        data.message +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>');

                    $('#add-element input').removeClass("is-invalid").val("");
                    $("#btn-add-element").prop('disabled', false);

                    if (data.type === "success") {
                        setTimeout(function () {
                            window.location.reload()
                        }, 500)
                    }
                }
            });
        });

        $('#btn-edit-element').on('click', () => {
            $("#btn-edit-element").prop('disabled', true);

            $.ajax({
                url: '{{route('admin.roulette.edit')}}',
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                },
                data: 'id=' + $('#mid').val() + '&type=' + $('#mtype').val() + '&number=' + $('#mnumber').val() + '&title=' + $('#mtitle').val() + '&color=' + $('#mcolor').val(),
                success: (data) => {
                    $("#alert-modal").html('<div class="alert alert-' + data.type + '" id="roulette-malert">' +
                        data.message +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>');

                    $('#edit-element input').removeClass("is-invalid").val("");
                    $("#btn-edit-element").prop('disabled', false);
                    if (data.type === "success") {
                        setTimeout(function () {
                            window.location.reload()
                        }, 500)
                    }
                }
            });
        });

        function deleteElement(id) {
            Swal.fire({
                title: "Souhaitez vous reelement supprimer l'élement #" + id + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __('messages.YES') }}',
                cancelButtonText: '{{ __('messages.NO') }}'
            }).then((result) => {
                if (result.value) {
                    let xhr = new XMLHttpRequest();
                    xhr.open('get', '{{substr(route('admin.roulette.delete', ['id' => 1]), 0, -1)}}' + id);
                    xhr.send();

                    Toast().fire({
                        icon: "success",
                        title: "{{ __('messages.Updated') }}"
                    });

                    xhr.onload = function () {
                        console.log(xhr.response);
                    };
                    setTimeout(function () {
                        window.location.reload()
                    }, 500)
                }
            });
        }

        function addColor() {

            let text = document.getElementById('text');
            let boo = document.getElementById('color');

            boo.onchange = function makeReadable() {
                text.value = boo.value;

                if (tinycolor.isReadable("rgba(0, 0, 0, 0.9)", boo.value)) {
                    text.classList.remove('light-text');
                    text.classList.add('dark-text');
                } else {
                    text.classList.remove('dark-text');
                    text.classList.add('light-text');
                }
            };
        }

        function editColor() {

            let text = document.getElementById('mtext');
            let boo = document.getElementById('mcolor');

            boo.onchange = function makeReadable() {
                text.value = boo.value;

                if (tinycolor.isReadable("rgba(0, 0, 0, 0.9)", boo.value)) {
                    text.classList.remove('light-text');
                    text.classList.add('dark-text');
                } else {
                    text.classList.remove('dark-text');
                    text.classList.add('light-text');
                }
            };
        }

        document.body.onload = addColor();
        document.body.onload = editColor();

    </script>
@endif

<style>
    .color-picker {
        display: block;
        position: relative;
        overflow: hidden;
        border-radius: 5px;
        width: 100%;
        transition: 0.2s;
        border: 1px solid rgba(255, 255, 255, .05);
        box-shadow: 0 0 2px rgba(0, 0, 0, .1);
    }

    .color-picker > input.color {
        display: block;
        width: 111%;
        border: none;
        outline: none;
        height: 70px;
        background: 0;
        margin: -9px;
        cursor: pointer;
    }

    .color-picker > input.hex {
        border: 0;
        background: 0;
        padding: 14.5px;
        margin: 0;
        position: absolute;
        top: 1px;
        right: 1px;
        bottom: 1px;
        left: 50px;
        width: calc(100% - 52px);
        color: #333;
        background: rgba(255, 255, 255, .2);
        border-radius: 2px;
        outline: 0;
    }

    .color-picker > input.hex.light-text {
        color: rgba(255, 255, 255, .83);
    }

    .color-picker > input.hex.dark-text {
        color: rgba(0, 0, 0, .83);
    }
</style>