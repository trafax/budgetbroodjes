<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Extra;
use App\Models\Product;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * GET /1/settings: opvragen van instellingen
 * GET /1/zipcodes: opvragen postcodegebieden voor bezorgen
 * GET /1/open: opvragen openingstijden
 * GET /1/closed: opvragen data gesloten (bijv. feestdagen)
 * GET /1/products: opvragen producten
 * GET /1/extras: opvragen extras
 * GET /1/categories: opvragen categorieën
 * POST /1/order: plaatsen van een order
 *
 * IMG https://api.foodticket.net/foodticket/images/2391/luxe-bol-carapaccio.jpg
 */

class FoodticketController extends Controller
{
    public $client_id;
    public $api_key;

    public function __construct()
    {
        $this->middleware('role:admin');

        $this->client_id = 1647;
        $this->api_key = '7edb461d21cd6ff44028a05db78f7e56';
    }

    public function index()
    {
        return view('foodticket.index');
    }

    public function sync_categories()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => [
                'X-OrderBuddy-Client-Id: '. $this->client_id,
                'X-OrderBuddy-API-Key: '. $this->api_key
            ],
            CURLOPT_POST => FALSE,
            CURLOPT_HEADER => FALSE,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => 'https://api.foodticket.net/1/categories'
        ]);
        $string = curl_exec($curl);

        $xml = simplexml_load_string($string);

        foreach ($xml->row as $row)
        {
            $dateCheckStart = DateTime::createFromFormat('Y-m-d', (string) $row->start);
            $dateCheckStart = $dateCheckStart != false ? $dateCheckStart->format('Y-m-d') : NULL;
            $dateCheckEnd = DateTime::createFromFormat('Y-m-d', (string) $row->end);
            $dateCheckEnd = $dateCheckEnd != false ? $dateCheckEnd->format('Y-m-d') : NULL;

            $category = Category::updateOrCreate([
                'foodticket_id' => $row->id
            ], [
                'foodticket_id' => $row->id,
                'title' => $row->title,
                'slug' => Str::slug($row->title),
                'start_at' => ($row->start == '' ? NULL : $row->start),
                'end_at' => ($row->end == '' ? NULL : $row->end)
            ]);
        }

        return TRUE;
    }

    public function sync_products()
    {
        /**
         * Alle producten op oud zetten zodat deze achteraf verwijderd kunnen worden als deze
         * niet meer voorkomen in de foodticket kassa
         */
        Product::where('foodticket_id', '!=', NULL)->update(['old' => 1]);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => [
                'X-OrderBuddy-Client-Id: '. $this->client_id,
                'X-OrderBuddy-API-Key: '. $this->api_key
            ],
            CURLOPT_POST => FALSE,
            CURLOPT_HEADER => FALSE,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => 'https://api.foodticket.net/1/products'
        ]);
        $string = curl_exec($curl);

        $xml = simplexml_load_string($string);

        foreach ($xml->row as $row) {

            $category = Category::select('id')->where('foodticket_id', $row->main_category_id)->first();

            $product = Product::updateOrCreate([
                'foodticket_id' => $row->id
            ], [
                'foodticket_id' => $row->id,
                'title' => $row->title,
                'slug' => Str::slug($row->title),
                'description' => $row->description,
                'price' => $row->price,
                'old' => 0
            ]);

            $product->categories()->detach();

            if ($category)
                $product->categories()->attach($category->id);
        }

        /**
         * Alle niet gewijzigde producten uit de kassa verwijderen
         */
        Product::where('foodticket_id', '!=', NULL)->where('old', 1)->delete();

        return TRUE;
    }

    public function sync_extras()
    {
        DB::table('extra_product')->where('foodticket_id', '!=', NULL)->delete();

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => [
                'X-OrderBuddy-Client-Id: '. $this->client_id,
                'X-OrderBuddy-API-Key: '. $this->api_key
            ],
            CURLOPT_POST => FALSE,
            CURLOPT_HEADER => FALSE,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => 'https://api.foodticket.net/1/extras'
        ]);
        $string = curl_exec($curl);

        $xml = simplexml_load_string($string);

        foreach ($xml->row as $row) {

            // $extra = Extra::updateOrCreate([
            //     'foodticket_id' => $row->id
            // ], [
            //     'foodticket_id' => $row->id,
            //     'title' => $row->title,
            //     'selectable' => $row->selectable,
            // ]);

            $extra = Extra::updateOrCreate([
                'title' => $row->title
            ], [
                'foodticket_id' => $row->id,
                'title' => $row->title,
                'selectable' => $row->selectable,
            ]);

            // Hier moet een oplossing voor bedacht worden
            //$extra->products()->detach();

            $product_ids = explode(',', $row->product_ids);
            foreach ($product_ids as $product_id) {
                $product = Product::select('id')->where('foodticket_id', $product_id)->first();

                if ($product) {
                    foreach($row->items->item as $item) {
                        $extra->products()->attach($product->id, ['foodticket_id' => $item->id, 'title' => $item->title, 'price' => $item->price, 'sort' => $item->prio]);
                    }
                }
            }
        }

        return TRUE;
    }

    public function sync_images()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => [
                'X-OrderBuddy-Client-Id: '. $this->client_id,
                'X-OrderBuddy-API-Key: '. $this->api_key
            ],
            CURLOPT_POST => FALSE,
            CURLOPT_HEADER => FALSE,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => 'https://api.foodticket.net/1/products'
        ]);
        $string = curl_exec($curl);

        $xml = simplexml_load_string($string);

        foreach ($xml->row as $row) {

            $product = Product::where('foodticket_id', $row->id)->first();

            if (strlen($row->image) > 2) {
                $fileData = file_get_contents('https://api.foodticket.net/'. $row->image);
                $ext = explode('.', $row->image);
                $ext = end($ext);
                Storage::disk('public')->put('products/'.$row->id.'.' . $ext, $fileData);

                $product->image = 'products/'.$row->id.'.' . $ext;
                $product->save();
            }
        }

        return TRUE;
    }
}
