<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require ('./vendor/autoload.php');
$app = new \Slim\Slim(array(
    'debug' => true
        ));

class AllCapsMiddleware extends \Slim\Middleware {

    public function call() {
        // Get reference to application
        $app = $this->app;

        $req = $app->request;

        //print_r($req);exit;
        // Run inner middleware and application
        $this->next->call();

        // Capitalize response body

        $res = $app->response;
        //$body = $res->getBody();
        if ($req->headers->get('Token') != "123456") {
            $res->setStatus(401);
            $res->setBody("{\"msg\":\"not authorised\"}");
        }
    }

}

$corsOptions = array(
    "origin" => "*",
    "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
);
$cors = new \CorsSlim\CorsSlim($corsOptions);

$app->add($cors);



//$app->add(new \CorsSlim\CorsSlim());
//$app->add(new \AllCapsMiddleware());
//$app->response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
$app->response->headers->set('Content-Type', 'application/json');




$app->group('/frontend', function () use ($app) {


    $app->post('/userSignup', 'userSignup');
    $app->post('/userLogin', 'userLogin');
    $app->post('/forgetpassword', 'forgetpassword');
    $app->post('/changepassword', 'changepassword');
    $app->post('/listProducts', 'listProducts');
    $app->post('/ProductsDetails', 'ProductsDetails');
    $app->post('/addFavoriteProduct', 'addFavoriteProduct');
    $app->post('/myFavoriteProduct', 'myFavoriteProduct');
    $app->post('/updateProfile', 'updateProfile');
    $app->post('/userprofile', 'userprofile');
    $app->post('/updateProfilePhoto', 'updateProfilePhoto');
    // $app->post('/addProduct', 'addProduct');
    $app->post('/homeSettings', 'homeSettings');
    $app->post('/listmyProducts', 'listmyProducts');
    $app->post('/deleteProduct', 'deleteProduct');
    $app->post('/editProduct', 'editProduct');
    $app->post('/listCategory', 'listCategory');
    $app->post('/listSubcategory', 'listSubcategory');
    $app->post('/listCurrency', 'listCurrency');
    $app->post('/addToCart', 'addToCart');
    $app->post('/getCms', 'getCms');
    $app->post('/ListOrderSeller', 'ListOrderSeller');
    $app->post('/ListOrderBuyer', 'ListOrderBuyer');
    $app->post('/checkout', 'checkout');
    $app->post('/cartCount', 'cartCount');
    $app->post('/OrderDetails', 'OrderDetails');
    $app->post('/removeProductFromCart', 'removeProductFromCart');
    $app->post('/getCart', 'getCart');
    $app->post('/ListNotification', 'ListNotification');
    $app->post('/notiount', 'notiount');
    $app->post('/listbrand', 'listbrand');
    $app->post('/notifysettings', 'notifysettings');
    $app->post('/addAuction', 'addAuction');
    $app->post('/listmyAuctions', 'listmyAuctions');
    // $app->post('/getBrandId', 'getBrandId');
    $app->post('/getBrandIdNew', 'getBrandIdNew');
    $app->post('/emailverified', 'emailverified');
    $app->post('/auctionapproval', 'auctionapproval');
    $app->post('/interestedEmailToVendor', 'interestedEmailToVendor');
    $app->post('/auctionFeesAdvancePayment', 'auctionFeesAdvancePayment');
    $app->post('/addProductNew', 'addProductNew');
    $app->post('/listSubscriptions', 'listSubscriptions');
    $app->post('/addUserSubscription', 'addUserSubscription');
    $app->post('/getAuctionDates', 'getAuctionDates');
    $app->post('/auctionListSearch', 'auctionListSearch');
    $app->post('/listshops', 'listshops');
    $app->post('/getYears', 'getYears');
    $app->post('/bidsubmit', 'bidsubmit');
    $app->post('/getauctiondetails', 'getauctiondetails');
    $app->post('/listAuctionDtates', 'listAuctionDtates');
    $app->post('/getTimeslot', 'getTimeslot');
    $app->post('/listcuntry', 'listcuntry');
    $app->post('/liststatus', 'liststatus');
    $app->post('/getproductdetailsforedit', 'getproductdetailsforedit');
    $app->post('/newsleterRegister', 'newsleterRegister');
    $app->post('/ProductListSearch', 'ProductListSearch');
    $app->post('/listproductMessages', 'listproductMessages');
    $app->post('/getProductcontact', 'getProductcontact');
    $app->post('/getusercontact', 'getusercontact');
    $app->post('/addmessage', 'addmessage');
    $app->post('/getfullMessages', 'getfullMessages');

    $app->post('/UserSubscriptionpayment', 'UserSubscriptionpayment');
    $app->post('/markProduct', 'markProduct');

    $app->post('/listSubscribed', 'listSubscribed');
    $app->post('/changeLaguage', 'changeLaguage');
    $app->post('/listexpiredProducts', 'listexpiredProducts');
    $app->post('/markextension', 'markextension');
    $app->post('/userpayment', 'userpayment');
    $app->post('/userpaymentforupload', 'userpaymentforupload');
    $app->post('/adduserpayment', 'adduserpayment');
    $app->post('/listuserSubscriptions', 'listuserSubscriptions');

    $app->post('/auctionWinner', 'auctionWinner');
    
    
    

    $app->post('/addreview', 'addreview');

});
?>