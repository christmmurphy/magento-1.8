Dear Customer

Thank you for purchasing the extension(Custom Login Redirect Pro) with us.
Please follow the following documentation for installation/configuration & more:

========================================================
INSTALLATION
========================================================
Attention!! Before installation, be sure to disable the cache from backend: System > Cache Management or refresh the Cache after installation.
Disable the Compilation if enabled (System > Tools > Compilation)
1> Just drag & drop the 'app' folder in your root of Magento installation.
Note: This will not override the 'app' folder of your Magento installation but new folder/files of the extensions will be placed instead.

========================================================
CONFIGURATION
========================================================
Attention!! Be sure to logout & re-login before configuration else you will get '404 Error (Page not found)' in System > Configuration Page.
1> After installation go to Admin:
System >> Configuration >> MagePsycho Extensions >> Custom Login Redirect Pro >> Manage your setting here.
--------------------------------------------------------
Example:
--------------------------------------------------------

General Settings
--------------------------------------------------------
Enabled                                     = Yes
Domain Type				                    = Production
License Key (Production)*	                = Enter your License key here(Which will be sent in your email once you purchase the extension)
Default Login Redirection Url		        = {{referer}}
Default Logout Redirection Url		        = {{base_url}}
Logout Redirection Custom Message	        = You have logged out and will be redirected to our homepage in %d seconds.
Logout Redirection Delay Time		        = 2 Seconds
Default New Account Redirection 	        = {{base_url}}/customer/account
Newsletter Subscription Redirection Url     = {{base_url}}subscription-success
Redirect To Param                           = redirect_to
Enable Log							        = No

(Note: Don't forget to read the 'Valid Examples' & 'Notes' comments for more info about url structure)

Customer Group Selection Settings
--------------------------------------------------------
...

Customer Group Wise Login Redirection Url
--------------------------------------------------------
General = {{base_url}}welcome
Wholesale = http://wholesale.mystore.com/welcome
Retailer = http://reatiler.mystore.com/welcome
...

Customer Group Wise Logout Redirection Url
--------------------------------------------------------
General = {{base_url}}
...

Customer Group Wise New Account Redirection Url
--------------------------------------------------------
General = {{base_url}}/customer/account
...

Customer Group Wise New Account Email Template
--------------------------------------------------------
General = Default Template From Locale
...

Customer Group Wise New Account Success Message
--------------------------------------------------------
General = Thank you for registering with %s.
...

Please also note the settings comments which are quite self-explanatory.

========================================================
INSTALLATION / CONFIGURATION NOTES
========================================================
0> Disable the Cache before Installation or Refresh the Cache after Installation.
Disable the Compilation if enabled (System > Tools > Compilation)
1> If you get 'Access Denied' error in System > Configuration, then try to logout & re-login.
2> If you have community extension: Custom Login Redirect installed, please disable or uninstall it.
3> If you have custom theme then try to copy the following files:
app/design/frontend/default/default/layout/magepsycho_loginredirectpro.xml
app/design/frontend/default/default/layout/magepsycho_customerregfields.xml
app/design/frontend/default/default/template/magepsycho/loginredirectpro/*
app/design/frontend/default/default/template/magepsycho/customerregfields/*

to

app/design/frontend/[your-interface]/[your-theme]/layout/magepsycho_loginredirectpro.xml
app/design/frontend/[your-interface]/[your-theme]/layout/magepsycho_customerregfields.xml
app/design/frontend/[your-interface]/[your-theme]/template/magepsycho/loginredirectpro/*
app/design/frontend/[your-interface]/[your-theme]/template/magepsycho/customerregfields/*
4> Visit official site for more info: http://www.magepsycho.com/custom-login-redirect-pro.html

========================================================
CHANGELOG
========================================================
1.3.0 - 1.5.0
- Code Refinement
- Added version info
- Added locale translation
- Added custom variable {{redirect_to}} to redirect to the url mentioned in the query string param
- Added more variables like:
  {{ip}}
  {{country_code}}
  {{user_id}}
  {{user_group_id}}
  {{user_name}}
  {{user_email}}
- Removed dependency on Mage_Adminhtml_Block_System_Config_Form
- Added customer group wise new account/registration success message

1.1.0 - 1.3.0
- Code Refinement
- Added customer group selection feature during new account creation
- Added customer group wise new account email template
- Fixed redirection issue from onepage checkout login page.

0.3.0 - 1.1.0
- Refined the code
- Added default custom logout url
- Added customer group wise custom logout url
- Added default new account redirection url
- Added customer group wise new account redirection url
- Added option for time delay during logout redirection
- Added option for custom message during logout redirection
- Added option to redirection to referer/previous page url using {{referer}} variable

0.2.0 - 0.3.0
- Fixed the System > Configuration Form issue in 1.3.x version


========================================================
BUGS / NEW FEATURE REQUEST
========================================================
http://www.magepsycho.com/contacts

========================================================
VISIT US FOR MORE FREE/COMMERCIAL EXTENSIONS
========================================================
http://www.magepsycho.com/shop.html

========================================================
FOR SUPPORT
========================================================
http://www.magepsycho.com/contacts


Happy E-Commerce!!
MagePsycho Team