Requester
=========

 Requester is an API to make HTTP requests using Curl. Is an alternative version
of PHRequest but was ideally thinking to use in PHP 5.2 projects and to be a stand
alone class.

## Why use Requester ?

- Its built on Curl.
- Simplifies your live by making CURL actually usable.

## Usage
If you need to make a Request to get the content of some Url using Curl a clasic
code will look like this.

``` php
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
  curl_setopt($ch, CURLOPT_URL, 'http://www.google.com');

  $result = curl_exec($ch);

  if (curl_errno($ch) > 0) {
    //Handle Error
  }

  curl_close($ch);
```

Requester wraps all this awful code to make our lives easier.

In order to make a GET Request you should do this

``` php
$requester = new Requester();
$response = $requester->get('http://www.google.com');
```

Yes, only that. Looks nice, take a look to a POST Request.

To make a POST you can do this

``` php

$requester = new Requester();

$params = array (
  'param1' => 'Some Value',
  'param2' => 'Some other value',
);

$response = $requester->post('http://www.httpbin.org/post', $params);
```

and that's all folks!

The Response is the Raw content. Only with HEAD method will be provided
the head of the response.

To see more samples, check the tests (until I write more documentation).

## Proxy Support

If your are behind a proxy you need to define the Url of the proxy in order to
make the Request. Here is an example.

``` php
$requester = new Requester();
$proxy => array(
 'url' => 'http://prx_name_or_ip:3128'
);
$requester->setOptionProxy($proxy);
$response = $requester->get('http://www.httpbin.org/get');
```

If your proxy uses auth, try with this

``` php
$requester = new Requester();
$proxy => array(
  'url' => 'http://prx_name_or_ip:3128',
  'auth' => 'username:password',
  'auth_method' => 'BASIC' //Optional, BASIC By default, NTLM is the second option.
);
$requester->setOptionProxy($proxy);
$response = $requester->get('http://www.httpbin.org/get');
```
Requester supports NTLM authentication for people that is behind an ISA Server.

## HTTPS support

By default Requester will support HTTPS but without Peer Validation.

In order to validate the Peer you need to set the Certificate path to make
the validation.

``` php
$request = new Requester();
$request->setOptionSsl(dirname(__FILE__) . '/resources/ca/google2.pem');
$response = $request->get('https://www.google.com.ar');
```

## Save Remote Files Locally

To get a remote file and save it locally you can do the following.

``` php
$requester = new Requester();
$requester->save($pathToStore, 'http://www.someserver.com/somefile');
```

This save any request into a file. By default the file is fetched with GET, but
I know that sometimes we made mistakes and if some crazy head decide that
needs to use a diffrent method to fetch a file you can set the Method.

``` php
$requester = new Requester();

$data = array(...); //Array or String with data to include in the payload of the request, optional
$params = array(...); //Array or String with url encoded data to put as query string, optional

$requester->save($pathToStore, 'http://www.someserver.com/somefile', $data, $params, 'PUT'); //WAT!, yes, just in case
```

IMPORTANT : The BAD usage of this feature can create security problems, please
keep that in mind and be careful.

##Making several Requests

One of the main target of Requester is keep the context of the configuration in
order to make several request with only one setup.

``` php

$requester = new Requester(array(
    'timeout' => 40,
    'proxy' => array(
        'url' => 'http://uglyproxy.corp.com'
    )
));

$response = $requester->get('http://www.google.com');

//do something with the response

$response = $requester->get('http://www.google.com?q=php');

//do something with the response again, this is the same as abobe

$response = $requester->get('http://www.google.com', array('q' => 'php'));
```

All this request will be executed with the same parameters for proxy and timeout.

##Checking the Status Code of the Response

If you need check the status code of the response you can use the method getLastHttpCode. This
method will return the status code of the last request.


``` php

$requester = new Requester();
$response = $requester->get('http://www.google.com');
$responseStatusCode = $requester->getLastHttpCode();

```

## Response as Array

If you need the response metadata information (headers, times, status). You can
set the option Response Type (setOptionResponseType) to an Array, with this option
Requester will return an array with the content and more information of the request.

``` php

$requester = new Requester();
$requester->setOptionResponseType(Requester::RESPONSE_ARRAY);
$response = $requester->get('http://www.google.com');
echo $response['content'];
echo $response['status_code'];
echo $response['http_code'];
//And more options. 

```

## Supported methods.

 - GET
 - POST
 - PUT
 - DELETE
 - HEAD

## Support

If you want a special feature or if you find a bug, please, let me know.

If you want to contribute to the project, also, please let me know :).

casivaagustin@gmail.com