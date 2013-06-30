{include file='header' pageTitle='test'}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.jcoins.premiumgroups.{$action}{/lang}</h1>
	</hgroup>
</header>

<p class="info">{lang}wcf.acp.jcoins.premiumgroups.{$action}info{/lang}</p>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}wcf.global.success.{$action}{/lang}</p>	
{/if}

<div class="contentNavigation">

</div>

<form method="post" action="{if $action == 'add'}{link controller='JCoinsPremiumAdd'}{/link}{else}{link controller='JCoinsPremiumEdit' object=$premiumGroup}{/link}{/if}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>Benutzergruppeneinstellung</legend>
			
			<dl{if $errorField == 'jCoins'} class="formError"{/if}>
				<dt><label for="jCoins">jCoins</label></dt>
				<dd>
					<input type="integer" id="jCoins" name="jCoins" value="{$jCoins}" required="required" autofocus="autofocus" class="medium" />
					{if $errorField == 'jCoins'}
						<small class="innerError">
							{if $errorType == 'underZero'}
								kleiner als null
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
				
			<dl{if $errorField == 'period'} class="formError"{/if}>
				<dt><label for="period">Länge</label></dt>
				<dd>
					<input type="integer" id="period" name="period" value="{$period}" {if $action == 'edit'}readonly="readonly"{/if} class="medium" />
					{if $errorField == 'period'}
						<small class="innerError">
							{if $errorType == 'notValid'}
								Die Eingabe muss eine ganzzahl sein.. 
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
				
			<dl>
				<dt><label for="description">Beschriebung</label></dt>
				<dd>
					<textarea cols="40" rows="10" name="description" id="description">{$description}</textarea>
				</dd>
			</dl>
				
			{include file='multipleLanguageInputJavascript' elementIdentifier='description' forceSelection=false}
				
			<dl{if $errorField == 'groupID'} class="formError"{/if}>
				<dt><label for="groupID">Gruppe</label></dt>
				<dd>
				    {if $action == 'edit'}
					{if $premiumGroup->getGroup()->isEditable()}<a href="{link controller='UserGroupEdit' id=$premiumGroup->getGroup()->groupID}{/link}">{lang}{$premiumGroup->getGroup()}{/lang}</a>{else}{$premiumGroup->getGroup()}{/if}
					<input type="hidden" name="groupID" value="{$premiumGroup->getGroup()->groupID}" />
				    {else}
					<select name="groupID" id="groupID">
					    {foreach from=$groups item="group"}
						<option value="{$group->groupID}">{lang}{$group->groupName}{/lang}</option>
					    {/foreach}
					</select>
				    {/if}
				</dd>
			</dl>
		</fieldset>
	</div>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
	</div>
</form>

{include file='footer'}