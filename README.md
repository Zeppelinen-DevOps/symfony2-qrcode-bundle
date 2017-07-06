# UniCenter QRCode Bundle

### Installation
To install this bundle, run the command below and you will get the latest version from [Packagist][3].

@see https://github.com/Endroid/QrCode
``` bash
composer require endroid/qrcode
```

Then enable it in your kernel:
``` php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new Endroid\QrCode\Bundle\EndroidQrCodeBundle(),
    ];
}
```


@see https://github.com/KnpLabs/KnpSnappyBundle

With composer, add:
``` php
{
    "require": {
        "knplabs/knp-snappy-bundle": "~1.4"
    }
}
```

Then enable it in your kernel:
``` php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        //...
        new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
        //...
```

And set-up the required configuration
``` yaml
# app/config/config.yml
knp_snappy:
    pdf:
        enabled:    true
        binary:     /usr/local/bin/wkhtmltopdf #"\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe\"" for Windows users
        options:    []
    image:
        enabled:    true
        binary:     /usr/local/bin/wkhtmltoimage #"\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltoimage.exe\"" for Windows users
        options:    []
```

``` bash
composer require sfk/email-template-bundle dev-master
```

``` bash
composer require uc/qrcode-bundle dev-master
```

Load required bundles in AppKernel.php:

``` php
// app/AppKernel.php
public function registerBundles()
{
  $bundles = array(
    // [...]
    new Uc\PaymentBundle\UcQCodeBundle(),
  );
}
```

###### Create a QRCode

``` php
/**
 * $vars = [
 *     'code' => '' // Encode string,
 *     'orderId' => '' // Order ID
 * ]
 * @return string = '/uploads/tmp/orderId . date('dmY') .svg' // file location
 */
$QManager->generateQCode($vars = []);
```

###### Build a PDF

``` php
/**
 * $vars = [
 *     'html'    => '' //Html content which will be processed to pdf
 *     'name'  => '' //PDF name
 * ]
 * @return array = [
 *     'path' => '' //File location
 *     'pdf'  => '' //PDF raw
 * ]
*/
$PDFManger->progressPDF($vars = []);
```

###### Send email

``` php
/**
 * $vars = [
 *     'sender'    => '' //Email sender
 *     'recipient' => '' //Email recipient
 *     'subject'   => '' //Email subject
 *     'body'      => '' //Email body
 *     'pdf'       => '' //Attachment pdf file location
 * ]
*/
$DeliveryManager->onSendEmail($vars = []);
```
