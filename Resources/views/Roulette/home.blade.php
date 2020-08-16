<link rel="stylesheet" href="@PluginAssets('css/roulette.css')">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<div class="container">
    <div class="row">
        @if($relements->count() > 0)

            <div class="col-md-8 text-center">
                <h2 class="mb-3" style="text-align: left">
                    <span>{!! trans('roulette_arckene::general.frame.title_roulette') !!}</span></h2>
                @if(tx_auth()->isLogin())
                    @if(user()->money >= $rconfig['price'])
                        <div id="ajax-reponse" class="alert alert-success show" role="alert">
                            {!! trans('roulette_arckene::general.frame.message_success') !!} (<span
                                    style="text-transform: lowercase">{{ user()->money . " " . ( user()->money <= 1 ? site_config('pb') : site_config('pbs')) }}</span>).
                        </div>
                    @else
                        <div id="ajax-reponse" class="alert alert-danger show" role="alert">
                            {!! trans('roulette_arckene::general.frame.message_danger') !!} (<span
                                    style="text-transform: lowercase">{{ user()->money . " " . ( user()->money <= 1 ? site_config('pb') : site_config('pbs')) }}</span>).
                        </div>
                    @endif
                @else
                    <div id="ajax-reponse" class="alert alert-info show" role="alert">
                        {!! trans('roulette_arckene::general.frame.message_info') !!}
                    </div>
                @endif
                <div id="roulette" style="position: relative;height: 800px;">
                    <div id="chart"></div>
                </div>
            </div>
            <div class="col-md-4">
                <h2 class="mb-3"><span>{!! trans('roulette_arckene::general.frame.title_history') !!}</span></h2>
                <div id="history">
                    @foreach($rhistory as $h)
                        <div class="histoop">
                            <span class="number">#{{$h['id']}}</span>
                            <div class="info">
                                <div class="label">
                                    @if($relements->where('id', $h['element_id'])->count() > 0)
                                        @foreach($relements->where('id', $h['element_id']) as $e)
                                            {{$e['title']}} <span class="id">({{$e['id']}})</span>
                                        @endforeach
                                    @else
                                        {!! trans('roulette_arckene::general.frame.deleted_price') !!} <span class="id">({{$h['element_id']}})</span>
                                    @endif
                                </div>
                                <div class="user">
                                    {{ tx_model()->user->where('id', $h['user_id'])->first()["pseudo"] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                    <div class="col-md-12 my-5">
                        <div class="alert alert-danger show text-center" role="alert">
                            {!! trans('roulette_arckene::general.frame.message_count') !!}
                        </div>
                    </div>
                @endif
            </div>
    </div>
</div>


<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script src="@PluginAssets('js/jquery.paginate.js')" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">

    $('.histoop').paginate(8);

    const LangPlayTitle = "{!! trans('roulette_arckene::general.script.LangPlayTitle') !!}",
        LangPlayText = "{{ $rconfig["price"] }} {{ $rconfig["price"] <= 1 ? site_config('pb') : site_config('pbs') }}",
        LangLaunchTitle = "{!! trans('roulette_arckene::general.script.LangLaunchTitle') !!}",
        LangLaunchText = "{!! trans('roulette_arckene::general.script.LangLaunchText') !!}",
        LangLaunchedTitle = "{!! trans('roulette_arckene::general.script.LangLaunchedTitle') !!}",
        LangLaunchedText = "{!! trans('roulette_arckene::general.script.LangLaunchedText') !!}",
        LangGetPrice = "{!! trans('roulette_arckene::general.script.LangGetPrice') !!}";

    const ajaxUrl = "{{ route('roulette.ajax_roulette') }}";
    const ajaxBeforeSpin = "{{ route('roulette.ajax_beforeSpin') }}";
    const xhrGetPrice = "{{ route('roulette.getPrice') }}";

    const data = [
            @foreach($relements->take($rconfig['elements']) as $e)
        {
            "label": "{{$e['title']}}",
            "id": {{$e['id']}},
            "color": '{{$e['color']}}'
        },
        @endforeach
    ];
</script>
<script src="@PluginAssets('js/roulette.js')" charset="utf-8"></script>

<div class="modal fade" id="message" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="mess"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-block btn-primary">DAKOR</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8">
    @if(tx_auth()->isLogin())
    @if(user()->money < $rconfig['price'])
    button.on("click", null);
    $('#roulette').addClass('desactived');
    $('.chartholder g').removeClass('rotate');
    @endif
    @else
    button.on("click", null);
    $('#roulette').addClass('desactived');
    $('.chartholder g').removeClass('rotate');
    @endif
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>