<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Quote\Model\GuestCart;

use Magento\Quote\Api\GuestBillingAddressManagementInterface;
use Magento\Quote\Model\BillingAddressManagement;
use Magento\Quote\Model\QuoteIdMask;
use Magento\Quote\Model\QuoteIdMaskFactory;

/**
 * Billing address management service for guest carts.
 */
class GuestBillingAddressManagement implements GuestBillingAddressManagementInterface
{
    /**
     * @var QuoteIdMaskFactory
     */
    private $quoteIdMaskFactory;

    /**
     * @var BillingAddressManagement
     */
    private $billingAddressManagement;

    /**
     * Constructs a quote billing address service object.
     *
     * @param BillingAddressManagement $billingAddressManagement
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     */
    public function __construct(
        BillingAddressManagement $billingAddressManagement,
        QuoteIdMaskFactory $quoteIdMaskFactory
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->billingAddressManagement = $billingAddressManagement;
    }

    /**
     * {@inheritDoc}
     */
    public function assign($cartId, \Magento\Quote\Api\Data\AddressInterface $address)
    {
        /** @var $quoteIdMask QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        return $this->billingAddressManagement->assign($quoteIdMask->getId(), $address);
    }

    /**
     * {@inheritDoc}
     */
    public function get($cartId)
    {
        /** @var $quoteIdMask QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        return $this->billingAddressManagement->get($quoteIdMask->getId());
    }
}
