<link rel="stylesheet" href="@PluginAssets('css/roulette.css')">
<div class="container">
    <div class="row">
        @if($relements->count() > 0)
            <div class="col-md-8 text-center">
                <h1 class="text-left">{!! trans('roulette_arckene::general.frame.title_roulette') !!}</h1>
                @if(tx_auth()->isLogin())
                    @if(user()->money >= $rconfig['price'])
                        <div id="ajax-reponse" class="alert alert-success show" role="alert">
                            {!! __('roulette_arckene::general.frame.message_success') !!} (<span
                                    style="text-transform: lowercase">{{ user()->money . " " . ( user()->money <= 1 ? site_config('pb') : site_config('pbs')) }}</span>).
                        </div>
                    @else
                        <div id="ajax-reponse" class="alert alert-danger show" role="alert">
                            {!! __('roulette_arckene::general.frame.message_danger') !!} (<span
                                    style="text-transform: lowercase">{{ user()->money . " " . ( user()->money <= 1 ? site_config('pb') : site_config('pbs')) }}</span>).
                        </div>
                    @endif
                @else
                    <div id="ajax-reponse" class="alert alert-info show" role="alert">
                        {!! __('roulette_arckene::general.frame.message_info') !!}
                    </div>
                @endif
                <div id="roulette" style="position: relative;height: 800px;">
                    <div id="chart"></div>
                </div>
            </div>
            <div class="col-md-4">
                <h1 class="text-left">{!! __('roulette_arckene::general.frame.title_history') !!}</h1>
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
                                        {!! __('roulette_arckene::general.frame.deleted_price') !!} <span class="id">({{$h['element_id']}})</span>
                                    @endif
                                </div>
                                <div class="user">
                                    {{ tx_model()->user->where('id', $h['user_id'])->first()["pseudo"] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="col-md-12 my-5">
                <div class="alert alert-danger show text-center" role="alert">
                    {!! __('roulette_arckene::general.frame.message_count') !!}
                </div>
            </div>
        @endif
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript" charset="utf-8">
    const LangPlayTitle = "{!! __('roulette_arckene::general.script.LangPlayTitle') !!}"
        , LangPlayText = "{{ $rconfig["price"] }} {{ $rconfig["price"] <= 1 ? site_config('pb') : site_config('pbs') }}"
        , LangLaunchTitle = "{!! __('roulette_arckene::general.script.LangLaunchTitle') !!}"
        , LangLaunchText = "{!! __('roulette_arckene::general.script.LangLaunchText') !!}"
        , LangLaunchedTitle = "{!! __('roulette_arckene::general.script.LangLaunchedTitle') !!}"
        , LangLaunchedText = "{!! __('roulette_arckene::general.script.LangLaunchedText') !!}"
        , LangGetPrice = "{!! __('roulette_arckene::general.script.LangGetPrice') !!}"
        , ajaxUrl = "{{ route('roulette.ajax_roulette') }}"
        , ajaxBeforeSpin = "{{ route('roulette.ajax_beforeSpin') }}"
        , xhrGetPrice = "{{ route('roulette.getPrice') }}"
        , verifLogin = {{ tx_auth()->isLogin() }}
        , verifPoint = {{ user()->money >= $rconfig['price'] }}
        , paginate = 8
        , data = [@foreach($relements->take($rconfig['elements']) as $e){"label": "{{$e['title']}}","id": {{$e['id']}},"color": '{{$e['color']}}'},@endforeach];
</script>

<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script src="@PluginAssets('js/jquery.paginate.js')" charset="utf-8"></script>
<script src="@PluginAssets('js/roulette.js')" charset="utf-8"></script>