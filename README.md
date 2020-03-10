# Magento 2 Multi Custom Shipping Rate
Our Magento 2 multi custom shipping method extension provides two essential functionality for Magento store owner to fully take control of there store shipping options by providing the ability to quickly add custom shipping rates to both admin order creation or frontend customer.

## Custom Shipping Rate for Admin Order
Whether you are creating a new order or canceling and rewriting existing orders in Magento Admin, our admin shipping extension gives you the ability to apply a custom shipping rate, method, and description to any order. This free extension is essential for businesses that do a lot of phone orders or mail orders and want to offer special shipping cost for individual customers. With our admin shipping plugin extension changing shipping amount for a particular order is as easy as entering the shipping amount instead of choosing predefined standard shipping rates and invoice your customer as you would with any standard shipping rate.

## Custom Shipping Rate for Frontend Order
Instead of using complex shipping table rates, our extension simplifies your checkout process by giving you the ability to create an unlimited number of flat price shipping methods. Perfect for e-commerce stores that offer flat shipping prices for all their products. Improve your order conversion rate by offering your customers a simple checkout process using our shipping extension.

## Configuration
* Go to the `Stores -> Configurations -> Sales -> Shipping Methods -> Kashyap Custom Shipping Rate` where you can find various settings to configure the extension.

---

![Alt text](configuration.png?raw=true "Magento 2 Multi Custom Shipping Rate")

---

## Installation without composer
* Download zip file of this extension
* Place all the files of the extension in your Magento 2 installation in the folder `app/code/Kashyap/CustomShippingRate`
* Enable the extension: `php bin/magento --clear-static-content module:enable Kashyap_CustomShippingRate`
* Upgrade db scheme: `php bin/magento setup:upgrade`
* Deply Static Content: `php bin/magento setup:static-content:deploy -f` Developer Mode
* Deply Static Content: `php bin/magento setup:static-content:deploy` Production Mode

---

![Alt text](ShippingDisplay.png?raw=true "Magento 2 Multi Custom Shipping Rate")

---

![Alt text](ShippingDisplayAdmin.png?raw=true "Magento 2 Multi Custom Shipping Rate")

---

![Magento2 Custom Shippiing Rate Admin](http://kashyapsoftware.com/Custom_Shipping_Rate_for_Magento2_by_Kashyap.gif)

---

[![Alt text](https://www.kashyapsoftware.com/pub/media/logo/stores/1/ks_logo.png "kashyapsoftware.com")](https://www.kashyapsoftware.com/)

