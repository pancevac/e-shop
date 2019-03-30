<?php

/**
 * Get list of cart items
 *
 * @param bool $returnAsJson
 * @return array|mixed|string
 */
function getCartItems($returnAsJson = false) {

    return app('shoppingCart')->getShoppingCartItems($returnAsJson);
}

/**
 * Get the total price (calculated discounts) of the items in the cart.
 *
 * @param bool $format
 * @return mixed
 */
function getTotalPrice($format = false) {

    return app('shoppingCart')->getTotalPrice();
}

/**
 * Get the subtotal price (without discounts) of the items in the cart.
 *
 * @param bool $format
 * @return mixed
 */
function getSubtotalPrice($format = false) {

    return app('shoppingCart')->getSubtotalPrice();
}

/**
 * Return number of items in cart.
 *
 * @return mixed
 */
function getCartItemsCount() {

    return app('shoppingCart')->getCartCount();
}