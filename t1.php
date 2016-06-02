<?php
require 'php/autoload.php';
require 'php/sample-code-php-master/Constants.php';
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

define("AUTHORIZENET_LOG_FILE", "phplog");

echo 45;

function chargeCreditCard($amount){
    // Common setup for API credentials
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName('5Qt5Ye7838');
    $merchantAuthentication->setTransactionKey('8B4rXM8pD3486Has');
    $refId = 'ref' . time();

    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber("4111111111111111");
    $creditCard->setExpirationDate("1226");
    $creditCard->setCardCode("123");
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);

    $order = new AnetAPI\OrderType();
    $order->setDescription("New Item");

    //create a transaction
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType( "authCaptureTransaction");
    $transactionRequestType->setAmount($amount);
    $transactionRequestType->setOrder($order);
    $transactionRequestType->setPayment($paymentOne);


    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId( $refId);
    $request->setTransactionRequest( $transactionRequestType);
    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

    if ($response != null)
    {
        $tresponse = $response->getTransactionResponse();

        if (($tresponse != null) && ($tresponse->getResponseCode()== \SampleCode\Constants::RESPONSE_OK) )
        {
            echo "Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "\n";
            echo "Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
        }
        else
        {
            echo  "Charge Credit Card ERROR :  Invalid response\n";
        }

    }
    else
    {
        echo  "Charge Credit card Null response returned";
    }
    return $response;
}
if(!defined('DONT_RUN_SAMPLES'))
    chargeCreditCard(\SampleCode\Constants::SAMPLE_AMOUNT);
?>
