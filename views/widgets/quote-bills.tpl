{assign name="panelContent"}
    {foreach($bills as $bill)}
        {button class="btn-prinpary" label="{$bill->code}" href="{uri action='h-sales-bill-file' id='{$bill->id}'}"}
    {/foreach}
{/assign}

{panel type="info" title="{text key='h-sales.quote-sidebar-bills-title'}" content="{$panelContent}"}