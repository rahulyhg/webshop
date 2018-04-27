'use strict';

/**
 * Config constant
 */
app.constant('APP_MEDIAQUERY', {
    'desktopXL': 1200,
    'desktop': 992,
    'tablet': 768,
    'mobile': 480
});
app.constant('JS_REQUIRES', {
    //*** Scripts
    scripts: {
    'home': ['app/Controllers/homeCtrl.js'],
	'login': ['app/Controllers/loginCtrl.js'],
	'signup': ['app/Controllers/signupCtrl.js'],
	'my_account': ['app/Controllers/myAccountCtrl.js'],
    'invites': ['app/Controllers/invitesCtrl.js','app/service/productService.js'],
    'allmessage': ['app/Controllers/allmessageCtrl.js'],
    'message': ['app/Controllers/messageCtrl.js'],
	'cms': ['app/Controllers/cmsCtrl.js'], 
    'notifications': ['app/Controllers/notificationsCtrl.js'], 
	'reviews': ['app/Controllers/reviewsCtrl.js'],
	'invoices': ['app/Controllers/invoicesCtrl.js'],
        'inbox': ['app/Controllers/inboxCtrl.js'],
        'notification_settings': ['app/Controllers/NotificationSettingCtrl.js'],
	'accepted': ['app/Controllers/acceptedCtrl.js','app/service/productService.js'],
	'waitlisted': ['app/Controllers/waitlistedCtrl.js'],
	'wishlist': ['app/Controllers/wishlistCtrl.js'],
        'myProduct': ['app/Controllers/myProductCtrl.js'],
	'contact_us': ['app/Controllers/contactUsCtrl.js'],
	'change_password': ['app/Controllers/changePasswordCtrl.js'],
        'pay_now': ['app/Controllers/payNowCtrl.js'],
        'pay_success': ['app/Controllers/paySuccessCtrl.js'],
        'searchListing': ['app/Controllers/searchListingCtrl.js'],
         'addProduct': ['app/Controllers/addProductCtrl.js'],
        'productDetails': ['app/Controllers/productDetailsCtrl.js'],
             'ListOrderSeller': ['app/Controllers/ListOrderSellerCtrl.js'],
               'ListOrderBuyer': ['app/Controllers/ListOrderBuyerCtrl.js'],
                  'cart': ['app/Controllers/cartCtrl.js'],
                     'vendordashboard': ['app/Controllers/vendordashboardCtrl.js'],
                       'checkout': ['app/Controllers/checkoutCtrl.js'],
                         'payment_success': ['app/Controllers/payment_successCtrl.js'],
                          'order_details': ['app/Controllers/order_detailsCtrl.js'],
                            'failure': ['app/Controllers/failureCtrl.js'],
                               
        
              
              
         //Puja
         'addAuction': ['app/Controllers/addAuctionCtrl.js'],       
          'myAuction': ['app/Controllers/myAuctionCtrl.js'],
          'auctionDetails': ['app/Controllers/auctionDetailsCtrl.js'],
          'emailverify': ['app/Controllers/emailVerifyCtrl.js'],
           'addAuction2': ['app/Controllers/addAuctionCtrl2.js'], 
           'sendForAuction': ['app/Controllers/sendForAuctionCtrl.js'], 
           'addProduct2': ['app/Controllers/addProductCtrl2.js'],
           'purchaseSubscription': ['app/Controllers/purchaseSubscriptionCtrl.js'],




        //Suman
        'forgot_password': ['app/Controllers/forgot_passwordCtrl.js'],
       
        //Suman
        
        
        //spandan
        
        'SubscribedList': ['app/Controllers/SubscribedListCtrl.js'],
        
        
        
	
    },

    //*** angularJS Modules

    modules: [
        {
            name: 'angularMoment',
            files: ['vendor/moment/angular-moment.min.js']
        },
				 {
            name: 'ngFileUpload',
            files: ['node_modules/ng-file-upload/dist/ng-file-upload.min.js','node_modules/ng-file-upload/dist/ng-file-upload-shim.min.js']
        },
    ]
});
