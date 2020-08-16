<?php

namespace Extensions\Plugins\Roulette_arckene__208645946\App\Controllers\Admin;

use Extensions\Plugins\Roulette_arckene__208645946\App\Models\RouletteConfig;
use Extensions\Plugins\Roulette_arckene__208645946\App\Models\RouletteElements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\System\Extensions\Plugin\Core\PluginController as AdminController;

class HomeController extends AdminController
{
    // Docs.TrixCMS.Eu
    public $admin = true;

    public function index()
    {
        $rconfig = RouletteConfig::first();
        $relements = RouletteElements::orderByDesc('created_at')->get();
        if(empty($rconfig)) {
            $config = RouletteConfig::insertGetId([
                'elements' => 1,
                'price' => 0,
                'created_at' => now()
            ]);
        }
        View::share(compact('rconfig', 'relements'));
        return $this->view('Roulette.admin.home', __('roulette_arckene::general.plugin_name'));
    }


    public function configure(Request $request)
    {
        $element = $request->input('elem');
        $price = $request->input('price');

        if($element == null || $price == null) {
            return ['message' => trans("roulette_arckene::admin.Global.empty"), 'type' => 'danger'];
        } else {
            RouletteConfig::findOrFail(1)->update([
                'elements' => $element,
                'price' => $price,
                'updated_at' => now()
            ]);
            return ['message' => trans("roulette_arckene::admin.Configuration.success"), 'type' => 'success'];
        }
    }

    public function add(Request $request) {
        $type = $request->input('type');
        $number = $request->input('number');
        $title = $request->input('title');
        $color = $request->input('color');

        if($type == null || $number == null || $title == null || $color == null) {
            return ['message' => trans("roulette_arckene::admin.Global.empty"), 'type' => 'danger'];
        } else {
            RouletteElements::insertGetId([
                'element_id' => 0,
                'type' => $type,
                'number' => $number,
                'title' => $title,
                'color' => $color,
                'created_at' => now()
            ]);
            return ['message' => str_replace("#ID#", RouletteElements::orderByDesc('created_at')->first()['id'], trans("roulette_arckene::admin.Adding.success")), 'type' => 'success'];
        }
    }

    public function edit(Request $request) {
        $id = $request->input('id');
        $type = $request->input('type');
        $number = $request->input('number');
        $title = $request->input('title');
        $color = $request->input('color');

        if($id == null || $type == null || $number == null || $title == null || $color == null) {
            return ['message' => trans("roulette_arckene::admin.Global.empty"), 'type' => 'danger'];
        } else {
            RouletteElements::findOrFail($id)->update([
                'element_id' => 0,
                'type' => $type,
                'number' => $number,
                'title' => $title,
                'color' => $color,
                'updated_at' => now()
            ]);
            return ['message' => str_replace("#ID#", RouletteElements::orderByDesc('created_at')->first()['id'], trans("roulette_arckene::admin.Edit.success")), 'type' => 'success'];
        }
    }

    public function delete($id) {
        RouletteElements::findOrFail($id)->delete();
    }
}
