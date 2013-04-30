{include file='header' pageTitle='test'}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.jcoins.premiumgroups.{$action}{/lang}</h1>
	</hgroup>
</header>

{if $action == 'add'}
	<p class="info">{lang}wcf.acp.jcoins.premiumgroups.addinfo{/lang}</p>
{/if}

{if $action == 'edit'}
    <p class="info">{lang}wcf.acp.jcoins.premiumgroups.editinfo{/lang}</p>
{/if}

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}wcf.global.success.{$action}{/lang}</p>	
{/if}

<div class="contentNavigation">

</div>

<form method="post" action="{if $action == 'add'}{link controller='JCoinsPremiumAdd'}{/link}{else}{link controller='JCoinsPremiumEdit'}{/link}{/if}">
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
					<select name="groupID" id="groupID" {if $action == 'edit'}readonly="readonly"{/if}>
					    {foreach from=$groups item="group"}
						{if $group->isAccessible()}<option value="{$group->groupID}" {if $groupID == $group->groupID}selected="selected"{/if} >{lang}{$group->groupName}{/lang}</option>{/if}
					    {/foreach}
					</select>
				</dd>
			</dl>
		</fieldset>
	</div>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{if $premiumGroupID|isset}<input type="hidden" name="id" value="{@$premiumGroupID}" />{/if}
	</div>
</form>

{include file='footer'}