#GetSwish API test application
This is my take on exploring the GetSwish API, to develop easy-to-use wrapper methods for later use.
Feel free to try it out, but make sure to set the right file paths to the certificate files in your environment.
I've included the current test certificates that I've managed to convert, but since Swish could update anytime,
I take no responsibility for how well they're gonna work in the future.

##API documentation
Information and documentation are available at [GetSwish.se](https://www.getswish.se/handel/).

##License
Licenced as [CC-BY](https://creativecommons.org/licenses/by/3.0/)

##API support so far
Currently the application supports payment requests, status retrieval and simulation of the payment capture callback.
To keep it simple, all data is stored as session variables.

##Next step
No methods has been set up for refunds. It's on the todo list.

##Certificate setup
The API uses a TLS client certificate for https encryption. That part was a bit of a hassle to configure, since Apache
didn't seem to support the file formats provided by Swish.
Here are some links that helped me along the way:

**Configure Apache for SSL/TLS:**
http://www.discretelogix.com/blog/miscellaneous/installing-self-signed-ssl-certificate-on-wamp-server

**Split certificates to Apache-compatible files:**
Download openSSL: http://slproweb.com/products/Win32OpenSSL.html
Conversion guide: https://www.tbs-certificates.co.uk/FAQ/en/346.html
Important: add "-extensions ssl_client" to the command. (Source: https://github.com/coreos/etcd/issues/209)

**Test apache:**
http://blog.facilelogin.com/2008/07/enabling-ssl-on-wamp.html

**Fix for the error: "SSLSessionCache: 'shmcb' session cache not supported[...]"**
http://stackoverflow.com/questions/20127138/apache-2-4-configuration-for-ssl-not-working

**Fix for http status "403: Forbidden" when browsing localhost:**
https://www.youtube.com/watch?v=YMZT5AmYl1M
