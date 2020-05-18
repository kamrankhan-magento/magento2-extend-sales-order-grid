# Magento 2 Extend admin sales order grid

Whit this module you can extend the sales order admin grid and the relative Csv export with the order's comment.
## Setup

You can install this module via Composer or a manual setup.
To install it with composer you can insert this rows in your magento's composer.json
```
"require": {
	"ws/sales": "1.0.*"
    },
```
```
"repositories": {
	"m2_opengraph":{
            "type": "git",
            "url": "git@github.com:wallaceer/magento2-extend-sales-order-grid.git"
        }
    }
```
  
After edited composer.json 
- launch composer update
- verify the module status with `bin/magento module:status | grep Ws_Sales`
- enable the module, if necessary, with `bin/magento module:enable Ws_Sales`
- run bin/magento setup:upgrade
    
For a manual installation:
* copy the module in your magento `app/code`
* run `bin/magento setup:upgrade`
* verify the module status with `bin/magento module:status | grep Ws_Sales`


In every case remember to launch the command `bin/magento setup:upgrade` for cleaning the cache


## Note
This module was developed with Magento 2.3.4 CE   