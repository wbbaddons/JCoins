{include file='header' pageTitle='wcf.acp.jcoins.shop.item.add'}

<script data-relocate="true">
	//<![CDATA[
	$(function() {
		function toggleContainer(value) {
			for (var $name in $targetContainers) {
				if ($name === value) {
					$targetContainers[$name].show();
				}
				else {
					$targetContainers[$name].hide();
				}
			}
		}
		
		var $targetContainers = { };
		$('input[name=type]').each(function(index, input) {
			var $input = $(input);
			var $value = $input.prop('value');
			
			if (!$targetContainers[$value]) {
				var $container = $('#JCoinsShopItemType' + $.wcfEscapeID($value + 'Div'));
				if ($container.length) {
					$targetContainers[$value] = $container;
				}
			}
			
			$input.change(function(event) {
				toggleContainer($(event.currentTarget).prop('value'));
			});
		});
		
		toggleContainer('{@$type}');
	});
	//]]>
</script>

<header class="boxHeadline">
	<h1>{lang}wcf.acp.jcoins.shop.item.add{/lang}</h1>
</header>

{include file='formError'}

<div class="contentNavigation">
	{hascontent}
		<nav>
			<ul>
				{content}
					{event name='contentNavigationButtons'}
				{/content}
			</ul>
		</nav>
	{/hascontent}
</div>

<form method="post" action="{link controller='JCoinsShopItemAdd'}{/link}">
		
        <div id="general" class="container containerPadding">
                <fieldset>
                        <legend>{lang}wcf.acp.jcoins.shop.item.general{/lang}</legend>

                        <dl>
                                <dt><label for="name">{lang}wcf.jcoins.shop.item.name{/lang}</label></dt>
                                <dd>
                                        <input type="text" id="name" name="name" value="{$name}" class="medium" />
                                         {if $errorField == 'name'}
                                                <small class="innerError">
                                                        {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                                                </small>
                                        {/if}
                                </dd>
                        </dl>
                                
                        <dl>
                                <dt><label for="description">{lang}wcf.jcoins.shop.item.description{/lang}</label></dt>
                                <dd>
                                        <input type="text" id="username" name="description" value="{$description}" class="medium" />
                                </dd>
                        </dl>
                                
                        <dl>
                                <dt><label for="price">{lang}wcf.jcoins.shop.item.price{/lang}</label></dt>
                                <dd>
                                        <input type="number" id="price" name="price" value="{$price}" class="medium" />
                                         {if $errorField == 'price'}
                                                <small class="innerError">
                                                        {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                                                </small>
                                        {/if}
                                </dd>
                        </dl>

                        {event name='generalFields'}
                </fieldset>

                {event name='generalFieldsets'}
                
                <fieldset{if $errorField == 'type'} class="formError"{/if}>
                        <legend>{lang}wcf.acp.jcoins.shop.item.types{/lang}</legend>

                        <dl>
                                <dt></dt>
                                <dd>
                                        {foreach from=$types item=t}
                                                <label><input type="radio" name="type" value="{$t->getObjectID()}" {if $type == $t->getObjectID()}checked="checked" {/if}/> {lang}wcf.jcoins.shop.item.type.{$t->name}{/lang}</label>
                                        {foreachelse}
                                            <p class="error">This should never happen! Don't play in the database :) If you have not done that, contact Josh :)</p>
                                        {/foreach}

                                        {event name='types'}

                                        {if $errorField == 'type'}
                                                <small class="innerError">
                                                        {if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
                                                </small>
                                        {/if}
                                </dd>
                        </dl>
                </fieldset>

                {foreach from=$types item=t}
                    {if $t->getParameters()}
                        <div id="JCoinsShopItemType{$t->getObjectID()}Div">
                                <fieldset>
                                        <legend>{lang}wcf.jcoins.shop.item.type.{$t->name}{/lang}</legend>

                                        {foreach from=$t->getParameters() item=param}
                                            {include file='jCoinsShopItemParameter' parameter=$param}
                                        {/foreach}
                                </fieldset>
                        </div>
                    {/if}
                {/foreach}

                {event name='paramFieldsets'}
        </div>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{include file='footer'}