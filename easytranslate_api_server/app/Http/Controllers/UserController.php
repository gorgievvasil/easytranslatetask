<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($action)
    {
        //        
        return view('users', ['action' => $action, 'response' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $authController = new AuthController();
        $response = '';
        //
        try{            
            if($request->actionType == 'login') {
                $response = $authController->loginUser($request);        
            }
            else if($request->actionType == 'register')
            {
                $response = $authController->createUser($request);        
            }
//    dd($response->getData()->status);
// echo $response;
            // $responseData = json_decode($response['data'], true);
            $responseData = $response->getData();
            //  dd($responseData);
            // print_r($responseData);
            // $apiHeadersRequest = [
            //     'Accept' => 'application/json'                
            // ];

            //  $response = Http::post("http://127.0.0.1:8000/api/auth/login",
            //         [
            //             'email' => 'gjorgjiev.vasil@gmail.com',
            //             'password' => 'Tremnik@%231'
            //         ]
            //     );



            // $validateUser = Validator::make(
            //     $request->all(),
            //     [
            //         'name' => 'required',
            //         'email' => 'required|email|unique:users,email',
            //         'password' => 'required|min:8',
            //         'confirm-password' => 'required|same:password'
            //     ]
            // );

            // if($validateUser->fails()) {
            //     return view('users', ['action' => $request['actionType'], 'msg' => 'Invalid user data was entered!']);
            // }

            // $user = User::create(
            //     [
            //         'name' => $request->name,
            //         'email' => $request->email,
            //         'password' => Hash::make($request->password)
            //     ]                
            // );

            if($responseData->status == true) {
                $resultMsg = '<h1>' . $request->name . ' your registration is successful!</h1>
                    <br/>
                    <br/>
                    <h2>Your token: <b><u>' . $responseData->token . '</u></b><h2>
                    <br/>
                    <span>Save your token on safe place. You need this token to be able to use this conversion service</span>
                    <br/><br/>
                    <a class="btn btn-primary" href="/">Go to the conversion service page</a>';
                    $responseData->status = 1;
                return view('users', ['action' => '', 'response' => $responseData]);
            } 
            else if($responseData->status == false) {
                $errors = '<ul>';
                foreach($responseData->errors as $key => $value) {
                    foreach($value as $k => $v) {
                        $errors .= '<li>' . $v . '</li>';
                    }
                }
                $errors .= '</ul>';
                $resultMsg = '<h1>Registration failed!</h1>
                    <br/>
                    <br/>
                    <h3>Errors:</h3>' . $errors;
                    $responseData->status = 0;
                return view('users', ['action' => 'register', 'response' => $responseData]);
            }
            
        }
        catch(\Throwable $t) {
            return view('users', ['action' => $request['actionType'], 'msg' => 'Something wrong happened. Error: ' . $t->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
