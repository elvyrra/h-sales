<?php

namespace Hawk\Plugins\HSales;

class QuoteBillsWidget extends Widget {
    public function display() {
        if($this->quote) {
            $bills = $this->quote->getBills();

            if(empty($bills)) {
                return '';
            }

            return View::make($this->getPlugin()->getView('widgets/quote-bills.tpl', array(
                'quote' => $this->quote,
                'bills' => $bills
            )));
        }

        return '';
    }
}