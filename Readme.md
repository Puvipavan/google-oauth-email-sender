# Email Sender
This is a simple email sender implemented for SSD Assignment in my college. Intention of this assignment is to use **OAuth Authorization Server** and **Resource API**. In this case I have used Google OAuth Authorization Server and the Google Resource API
> Note: I haven't used Google PHP SDK

### Prerequisites
- PHP with Curl Library installed and enabled
- Create a project in Google Cloud Console and create both OAuth Client ID(Web Application) and API Key
- OAuth Client ID must have following redirect URI
	-  http://localhost/callback.php 
	> Note:  If you are running localhost server other than port 80 then mention  port number in that redirect URI and also in the in configs.php file.
- Oauth consent screen must have following Scopes. 
	-  https://www.googleapis.com/auth/gmail.metadata 
	- https://www.googleapis.com/auth/gmail.send

### Run The Application
- Clone this repository to the root directory of a web server. If you have arranged files in to another directory, then do not forget to change the URI in both OAth API Credentials and configs.php
- Replace API Key, Secret and Client ID in configs.php
- Visit http://localhost/index.php to login
---