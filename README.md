This repo contains currency converter which uses API requests. Contains two parts:
- Laravel API server (easytranslate_api_server) - to "listen" for API requests
- Test site (easytranslate_api_client) - to send API requests to the Laravel API server

Setup Laravel API server locally:
- Laravel application
- Update the .env file with the appropriate information, according your local settings
- Use MySQL database
- Run "php artisan migrate" command to execute all migrations and create appropriate table in the database
- In the .env file add the following entry:
	FIXER_API_TOKEN="EpJWxwgY1RknvxeUpW2sN4VRSAyRBG9K"
	This entry is required because it is the access token to the fixer.io server, from where we are getting the conversion rates and currencies list.
- Run "php artisan serve" command to start the Laravel app	
- API routes:
	- /api/auth/register - POST route. Register user. Required data: name, email, password, password_confirmation
	- /api/auth/login - POST route. Login user. Required data: email, password
	- /api/conversion - POST route. Convert from source to target currency. Required data: source_currency, target_currency, amount
	- /api/conversion/rate - GET route. Get conversion rate. Required data: source_currency, target_currency
	- /api/conversion/currencies - GET route. Get list of available currencies on fixer.io.	
- These API routes can be tested using Postman (tool for API testing), or using the test site (easytranslate_api_client) which is acting like API client
- /api/conversion/* routes require authentication with token. This token each user is getting on registration or login
- Validation is done on Laravel API Server side
- API routes return JSON response which is easy to understand and parse
- Result for each conversions are stored in the database, in the "conversions" table
- Contains feautre tests for "/api/conversion" and "/api/auth/login" routes. Run command "php artisan test" to execute the tests

Setup Laravel API Client (site for testing API requests)
- Purpose of this website is to provide better user experience for testing API routes.
- Options for user management (registration and login), get rates for currencies and convert currencies.
- Toast notifications after action is finished
- API requests are sent in AJAX request
- After user registration or login token field is automatically filled
- If the user is logged in on page load API requests to the route "/api/conversion/currencies" is sent. Response from this request is list of currencies from the fixer.io. 
  "Currencies From" and "Currencies To" drop down lists are populated with the currencies which this API request returns as response.
- CSS and JS resources are in the "Assets" directory
- This client website has configuration file "settings.ini" which is in the root (on same level as index.php). This config file contains information for the host on which the API server is running. 
  By default the content in settings.ini is the default address on which Laravel is running:
  "api_server=127.0.0.1:8000"
  