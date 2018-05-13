<?php
namespace Concrete\Package\CommunityStoreCash\Src\CommunityStore\Payment\Methods\CommunityStoreCash;

use Core;
use Config;

use \Concrete\Package\CommunityStore\Src\CommunityStore\Payment\Method as StorePaymentMethod;

class CommunityStoreCashPaymentMethod extends StorePaymentMethod
{
    public function getName()
    {
        return t('Cash');
    }

    public function dashboardForm()
    {
        $this->set('form', Core::make("helper/form"));
        $this->set('cashMinimum', Config::get('community_store.cashMinimum'));
        $this->set('cashMaximum', Config::get('community_store.cashMaximum'));
        $this->set('cashPaymentInstructions', Config::get('community_store.cashPaymentInstructions'));
    }

    public function save(array $data = [])
    {
        Config::save('community_store.cashMinimum', $data['cashMinimum']);
        Config::save('community_store.cashMaximum', $data['cashMaximum']);
        Config::save('community_store.cashPaymentInstructions', $data['cashPaymentInstructions']);
    }
    public function validate($args, $e)
    {
        return $e;
    }

    public function checkoutForm()
    {
        $pmID = StorePaymentMethod::getByHandle('community_store_cash')->getID();

        $this->addFooterItem("
            <script type=\"text/javascript\">
                 $(function() {
                     $('div[data-payment-method-id=".$pmID."] .store-btn-complete-order').click(function(){
                         $(this).attr({disabled: true}).val('" .  t('Processing...').  "');
                         $(this).closest('form').submit();
                     });
                 });
            </script>
        ");
    }

    public function submitPayment()
    {

        //nothing to do except return success
        return array('error' => 0, 'transactionReference' => '');
    }

    public function getPaymentMinimum()
    {
        $defaultMin = 0;

        $minconfig = trim(Config::get('community_store.cashMinimum'));

        if ($minconfig == '') {
            return $defaultMin;
        } else {
            return max($minconfig, $defaultMin);
        }
    }

    public function getPaymentMaximum()
    {
        $defaultMax = 1000000000;

        $maxconfig = trim(Config::get('community_store.cashMaximum'));
        if ($maxconfig == '') {
            return $defaultMax;
        } else {
            return min($maxconfig, $defaultMax);
        }
    }

    public function markPaid() {
        return false;
    }

    // to be overridden by individual payment methods
    public function getPaymentInstructions()
    {
        return Config::get('community_store.cashPaymentInstructions');
    }
}
