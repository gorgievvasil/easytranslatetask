<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/js_scripts.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/custom_style.css" />    
</head>
<body>
<?php
    $config = parse_ini_file('config.ini');
    $token = "";
    $responseUserData = "";

    if(isset($_COOKIE['token']) && $_COOKIE['token'] != "") {
        
        $token = $_COOKIE['token'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $config['api_server'] . "/api/conversion/currencies",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Bearer " . $token
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        $responseData = json_decode($response);    

    }   
?>
<h1 class="mt-5 text-center">Easy Currency Conversion</h1>
    <p class="mt-5 text-center">
        <?php
            if($token == "") {
                echo 'To use this convertor your token is required.<br/>If you don\'t have token yet, please <span class="register-span">register</span> or <span class="login-span">sign in</span> to get your token.';
            }
            else {
                echo '<span class="logout-span">Logout</span> when you will finish using this convertor.';
            }
        ?>
    </p>

    <div class="col-6 m-auto mt-5 pb-5 user-registration-div">
        <form method="post" class="col-md-8 col-sm-12 m-auto mt-5 user-form">
            <input type="hidden" name="actionType" value="register" />            
            <div class="row text-left mt-3">
                <label for="name" class="form-label col-4 text-start">Name</label>                    
                <div class="col-8">
                    <input type="text" class="form-control inline-element col-8 name" id="name" name="name" placeholder="John Doe" />                                    
                </div>                    
            </div>
            <div class="row text-left mt-3">
                <label for="email" class="form-label col-4 text-start">E-mail</label>                    
                <div class="col-8">
                    <input type="text" class="form-control inline-element col-8 email" id="email" name="email" placeholder="jd@google.com" />                                    
                </div>                    
            </div>
            <div class="row text-left mt-3">
                <label for="password" class="form-label col-4 text-start">Password</label>                    
                <div class="col-8">
                    <input type="password" class="form-control inline-element col-8 password" id="password" name="password" placeholder="*********" />                                    
                </div>                    
            </div>
            <div class="row text-left mt-3">
                <label for="confirm-password" class="form-label col-4 text-start">Confirm Password</label>                    
                <div class="col-8">
                    <input type="password" class="form-control inline-element col-8 confirm-password" id="confirm-password" name="confirm_password" placeholder="*********" />                                    
                </div>                    
            </div>
            <div class="row mt-3">
                <button type="submit" id="submit-user" class="btn btn-primary get-token col-md-4 col-sm-10 m-auto" name="submit" value="user_form">Get Token</button>
            </div>    
        </form>
    </div>

    <div class="col-6 m-auto mt-5 pb-5 user-login-div">
        <form method="post" class="col-md-8 col-sm-12 m-auto mt-5 user-form">
            <input type="hidden" name="actionType" value="login" />                        
            <div class="row text-left mt-3">
                <label for="email" class="form-label col-4 text-start">E-mail</label>                    
                <div class="col-8">
                    <input type="text" class="form-control inline-element col-8 email" id="email" name="email" placeholder="jd@google.com" />                                    
                </div>                    
            </div>
            <div class="row text-left mt-3">
                <label for="password" class="form-label col-4 text-start">Password</label>                    
                <div class="col-8">
                    <input type="password" class="form-control inline-element col-8 password" id="password" name="password" placeholder="*********" />                                    
                </div>                    
            </div>            
            <div class="row mt-3">
                <button type="submit" id="submit-user" class="btn btn-primary get-token col-md-4 col-sm-10 m-auto" name="submit" value="user_form">Get Token</button>
            </div>    
        </form>
    </div>
    
    <div class="loader-user-wrapper">
        <div class="d-flex justify-content-center loader-user mt-5">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div class="row text-center col-md-6 col-sm-12 m-auto mt-4 content-container">       
        <form method="post" action="/">   
            <fieldset <?php if($token == "") echo "disabled"; ?>>              
                <div class="row mt-5">
                    <div class="col-6">
                        <label for="currency-from" class="form-label">From</label>
                        <select id="currency-from" class="form-select" name="currency_from">
                            <option value="select_currency" selected>Select currency</option>
                            <?php                            
                                if($responseData->success == true) {
                                    foreach($responseData->symbols as $key => $value) {
                                        echo '<option value="' . $key . '">' . $key . ' - ' . $value . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="currency-to" class="form-label">To</label>
                        <select id="currency-to" class="form-select" name="currency_to">
                            <option value="select_currency" selected>Select currency</option>
                            <?php
                                if($responseData->success == true) {
                                    foreach($responseData->symbols as $key => $value) {
                                        echo '<option value="' . $key . '">' . $key . ' - ' . $value . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div>
                        <label for="amount-to-convert" class="form-label inline-label" style="width: 200px; display:inline-block;">Amount to convert</label>
                        <div style="width: 200px; display:inline-block;">
                            <div class="input-group">
                                <span class="input-group-text">XXX</span>
                                <input type="text" class="form-control" id="amount-to-convert" name="amount_to_convert" placeholder="100" />
                            </div>                        
                        </div>
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div>
                        <label for="token" class="form-label inline-label" style="width: 200px; display:inline-block;">Token</label>
                        <div class="col-6" style="display:inline-block;">
                            <div class="input-group">                            
                            <input type="text" class="form-control inline-element col-8 token" id="token" name="token" value="<?php echo $token; ?>" placeholder="Enter here your API token" />   
                            </div>                        
                        </div>
                    </div>
                </div>            
                <div class="col-12 mt-3 text-center">
                    <span class="<?php if($token == "") echo ""; else echo "get-rate"; ?> text-md-center">Get rate</span><br/>
                    <span class="rate text-md-center"></span>
                </div>
                <div class="col-12 mt-2 text-center">                    
                    <button type="submit" class="btn btn-primary" id="submit-convert-btn" placeholder="100" name="convert" value="convert">Convert</button>
                </div>
            </fieldset>
        </form>
        <div class="converted-result m-auto mt-4 mb-4 col-5 p-3">
        </div>
    </div>
    
    <div class="loader-conversion-wrapper">
        <div class="d-flex justify-content-center loader-conversion mt-5 mb-5">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>    
    </div>

    <div class="toast position-absolute top-0 end-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto toast-title"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">            
        </div>
    </div>
    <input type="hidden" class="api-server-url" value="<?php echo $config['api_server']; ?>" />
</body>
</html>

