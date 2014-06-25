{event name='beforeParameter'}
<dl>
        <dt>
            {if $parameter.type != 'BOOL'}<label for="parameter{$parameter.parameterID}">{$parameter.name} <!-- TODO --></label>{/if}
        </dt>
        <dd>
            {if $parameter.type == 'TEXT'}
                <input type="text" id="parameter{$parameter.parameterID}" name="param_{$parameter.parameterID}_{$parameter.name}" value=""  class="medium">
            {elseif $parameter.type == 'INTEGER'}
                <input type="number" id="parameter{$parameter.parameterID}" name="param_{$parameter.parameterID}_{$parameter.name}" value="0"  class="medium">
            {elseif $parameter.type == 'BOOL'}
                <label><input id="parameter{$parameter.parameterID}" type="checkbox" name="param_{$parameter.parameterID}_{$parameter.name}" value="1"> {$parameter.name}</label>
            {/if}
            
            {event name='additionalParameter'}
            
            <small>@@TODO@@</small>
        </dd>
</dl>
{event name='afterParameter'}