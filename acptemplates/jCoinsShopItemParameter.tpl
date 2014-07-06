{event name='beforeParameter'}
<dl>
        <dt>
            {if $parameter.type != 'BOOL'}<label for="parameter{$parameter.parameterID}">{lang}wcf.jcoins.shop.item.type.{$t->identifer}.{$parameter.name}{/lang}</label>{/if}
        </dt>
        <dd>
            {if $parameter.type == 'TEXT'}
                <input type="text" id="parameter{$parameter.parameterID}" name="param_{$parameter.parameterID}_{$parameter.name}" value="{if $values[$parameter.parameterID]|isset}{$values[$parameter.parameterID]}{/if}"  class="medium">
            {elseif $parameter.type == 'INTEGER'}
                <input type="number" id="parameter{$parameter.parameterID}" name="param_{$parameter.parameterID}_{$parameter.name}" value="{if $values[$parameter.parameterID]|isset}{$values[$parameter.parameterID]}{else}0{/if}"  class="medium">
            {elseif $parameter.type == 'BOOL'}
                <label><input id="parameter{$parameter.parameterID}" type="checkbox" name="param_{$parameter.parameterID}_{$parameter.name}"{if $values[$parameter.parameterID]|isset && $values[$parameter.parameterID] == 1} checked="checked"{/if} value="1"> {lang}wcf.jcoins.shop.item.type.{$t->identifer}.{$parameter.name}{/lang}</label>
            {/if}
            
            {event name='additionalParameter'}
            
            <small>{lang}wcf.jcoins.shop.item.type.{$t->identifer}.{$parameter.name}.description{/lang}</small>
        </dd>
</dl>
{event name='afterParameter'}