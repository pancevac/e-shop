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

    return app('shoppingCart')->getTotalPrice($format);
}

/**
 * Get the subtotal price (without discounts) of the items in the cart.
 *
 * @param bool $format
 * @return mixed
 */
function getSubtotalPrice($format = false) {

    return app('shoppingCart')->getSubtotalPrice($format);
}

/**
 * Return number of items in cart.
 *
 * @return mixed
 */
function getCartItemsCount() {

    return app('shoppingCart')->getCartCount();
}

/**
 * Return discount value.
 *
 * @param bool $format
 * @return mixed
 */
function getDiscount($format = false) {

    return app('shoppingCart')->getDiscountPrice($format);
}

/**
 * Return discount value.
 *
 * @param $cartItem
 * @param bool $multiplyByQty
 * @return mixed
 */
function getPricePerProduct($cartItem, $multiplyByQty = true) {

    return app('shoppingCart')->getPricePerProduct($cartItem, $multiplyByQty);
}