<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sheets;
use Google;
use Usps;

class UpturnsController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //allow cross origin cors enabled
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');    
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); 
    }
    /**
     * Trigger the fetching of data from the google sheet
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Sheets::setService(Google::make('sheets'));
        Sheets::spreadsheet(env('GOOGLE_SHEET_ID'));
        $values = Sheets::sheet(env('GOOGLE_SHEET_NAME'))->all();
        dd(end($values));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the last inserted resource.
     * @param $order_id google sheet order id 
     * @return \Illuminate\Http\Response
     */
    public function show($order_id = null)
    {
        try {

            Sheets::setService(Google::make('sheets'));

            Sheets::spreadsheet(env('GOOGLE_SHEET_ID'));

            $values = Sheets::sheet(env('GOOGLE_SHEET_NAME'))->all();
            
            for($i=1;$i<=count($values);$i++ ){
                if ($values[$i][8] == $order_id) {

                    return response()->json([
                        'status' =>true,
                        'response' => $values[$i]
                    ], 200);
                }
            }

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => false,
                'response' => [],
                'error' => $e->getMessage()
            ],$e->getCode());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
    * Create label for a new request
    *@param  \Illuminate\Http\Request  $request
    */
    public function generateLabel(Request $request) {
        if ($request->has('label_type') && $request->has('from_name') && $request->has('from_firm') && $request->has('from_address1') && $request->has('from_address2') && $request->has('from_city') && $request->has('from_state') && $request->has('from_zip5') && $request->has('to_name') && $request->has('to_firm') && $request->has('to_address1') && $request->has('to_address2') && $request->has('to_city') && $request->has('to_state') && $request->has('to_zip5')) {
            # code...
        } else {
            return response()->json([
                'status'    => false,
                'response'  => 'Required params is missing!' 
            ],403);
        }
    }
}
