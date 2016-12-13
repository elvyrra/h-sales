<?php

namespace Hawk\Plugins\HSales;

/**
 * This widget displays the buttons to purpose actions on the displayed quote
 */
class QuoteActionsWidget extends Widget {
    public function display() {
        $buttons = array();

        $buttons[] = new ButtonInput(array(
            'class' => 'btn-default',
            'icon' => 'ban',
            'label' => Lang::get($this->_plugin . '.quote-sidebar-back-button'),
            'href' => App::router()->getUri('h-sales-quotes')
        ));

        if($this->quote) {
            // Print button
            $buttons[] = new ButtonInput(array(
                'class' => 'btn-info',
                'icon' => 'print',
                'label' => Lang::get($this->_plugin . '.quote-sidebar-print-button'),
                'href' => App::router()->getUri('h-sales-quote-pdf', array(
                    'quoteId' => $this->quote->id
                )),
                'target' => '_blank'
            ));

            // Send button
            $buttons[] = new ButtonInput(array(
                'class' => 'btn-primary',
                'icon' => 'envelope',
                'label' => Lang::get($this->_plugin . '.quote-sidebar-send-button'),
                'href' => App::router()->getUri('h-sales-quote-send', array(
                    'quoteId' => $this->quote->id
                )),
                'target' => 'newtab'
            ));

            // Button to create the bill from the quote
            $buttons[] = new ButtonInput(array(
                'class' => 'btn-success',
                'icon' => 'credit-card',
                'label' => Lang::get($this->_plugin . '.quote-sidebar-bill-button'),
                'href' => App::router()->getUri(
                    'h-sales-bill-file',
                    array(
                        'id' => 0
                    ),
                    array(
                        'from' => $this->quote->id
                    )
                ),
                'target' => 'newtab'
            ));
        }

        return implode('', array_map(function($button) {
            $button->class .= ' btn-block';

            return $button->display();
        }, $buttons));
    }
}