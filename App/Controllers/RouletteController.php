<?php

namespace Extensions\Plugins\Roulette_arckene__208645946\App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\System\Extensions\Plugin\Core\PluginController as Controller;
use Extensions\Plugins\Roulette_arckene__208645946\App\Models\RouletteElements;
use Extensions\Plugins\Roulette_arckene__208645946\App\Models\RouletteHistory;
use Extensions\Plugins\Roulette_arckene__208645946\App\Models\RouletteConfig;
use App\TModels\User;
use Illuminate\Support\Facades\DB;

class RouletteController extends Controller
{
    // Docs.TrixCMS.Eu
    public function index()
    {
        $rconfig = RouletteConfig::first();
        $rhistory = RouletteHistory::orderBy('id', 'desc')->get();
        $relements = RouletteElements::orderBy('element_id', 'asc')->get();
        View::share(compact('relements', 'rhistory', 'rconfig'));
        return $this->view('Roulette.home', __('roulette_arckene::general.plugin_name'));
    }

    public function ajax_beforeSpin(Request $request) {
        $data = $request->input('data');
        if(!empty($data)):
            $datac = encrypt($data);
            return response()->json(['data' => $datac])->getContent();
        endif;
    }


    public function getPrice() {
        $element = RouletteElements::orderBy(DB::raw('RAND()'))->first();
        $id = $element['id'];


        $rconfig = RouletteConfig::first();

        if (tx_auth()->isLogin()) {
            if (user()->money >= $rconfig['price']) {
                $relement = RouletteElements::getId($id);
                $gain = user()->money;
                if ($relement["type"] == 1) {
                    $gain += $rconfig['price'] * $relement["number"];
                } else if ($relement["type"] == 2) {
                    $gain += $relement["number"];
                }
                $gain -= $rconfig['price'];
                User::where('id', user()->id)->update(["money" => $gain]);
                RouletteHistory::insert([
                    "user_id" => user()->id,
                    "element_id" => $id,
                    "created_at" => now()
                ]);
            }
        }


        return $id;
    }





}
