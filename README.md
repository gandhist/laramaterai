### Unofficial Laravel library for eMaterai by Mekari

This is the unofficial library for eMaterai API by Mekari, for official documentation please visit [Mekari](https://mekari.com/)

## 1. Installation
Install using [Composer](http://composer.org/) CLI :
`composer require gandhist/laramaterai`
## 2. How to use

### 2.1 General Setting
Add to your env variables :
```env
    MATERAI_CLIENT_ID=<your client id>
    MATERAI_SECRET=<your client_secret>
    MATERAI_CODE=<your_auth_code>
    MATERAI_IS_PRODUCTION=false
```

Add `use Gandhist\Ematerai\Config;`, set configuration :
```php
    Config::$isProduction =  false;
    Config::$clientId =  env('MATERAI_CLIENT_ID');
    Config::$clientSecret =  env('MATERAI_SECRET');
    Config::$authCode =  env('MATERAI_CODE');
```

### 2. 2 Stamp a document
For stamping a document, you have to convert your PDF to base64, you can use [Base64 Guru](https://base64.guru/converter/encode/pdf) to convert your document.
Add `use Gandhist\Ematerai\Stamping;`
```php
$stamp =  new  Stamping;
$base64 = "your_base_64_pdf_file";
$filename = "your_file_name.pdf";
$annotation = [[
"page"  =>  4, // page you want to stamp
"position_x"  =>  150, // set x axis
"position_y"  =>  450, // set y axis
"element_width"  =>  80,
"element_height"  =>  80,
"canvas_width"  =>  836,
"canvas_height"  =>  1181,
"type_of"  =>  "meterai"
]];
$stamping = $stamp->stamp($base64, $filename, $annotation, $callback);
```
### 2.3 Get detail document by document id
Add `use Gandhist\Ematerai\Document;`
```php
$doc = new Document;
return $doc->detail("<document-id>");
```