{event name='beforeParameter'}
<dl>
        <dt>
            <label for="{$parameter.name}">{$parameter.name} <!-- TODO --></label>
        </dt>
        <dd>
            {if $parameter.type == 'TEXT'}
                <input type="text" id="{$parameter.name}" name="{$parameter.name}" value=""  class="medium">
            {elseif $parameter.type == 'INTEGER'}
                <input type="number" id="{$parameter.name}" name="{$parameter.name}" value="0"  class="medium">
            {/if}
            
            {event name='additionalParameter'}
            
            <small>@@TODO@@</small>
        </dd>
</dl>
{event name='afterParameter'}