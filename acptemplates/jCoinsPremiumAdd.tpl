{include file='header' pageTitle='wcf.acp.jcoins.premiumgroups.add'}

{include file='multipleLanguageInputJavascript' elementIdentifier='description' forceSelection=false}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.jcoins.premiumgroups.{$action}{/lang}</h1>
	</hgroup>
</header>

<p class="info">{lang}wcf.acp.jcoins.premiumgroups.{$action}info{/lang}</p>

{include file='formError'}

{if $success|isset}
	<p class="success">{lang}wcf.global.success.{$action}{/lang}</p>	
{/if}

<div class="contentNavigation">

</div>

<form method="post" action="{if $action == 'add'}{link controller='JCoinsPremiumAdd'}{/link}{else}{link controller='JCoinsPremiumEdit' object=$premiumGroup}{/link}{/if}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}wcf.acp.jcoins.groupsettings{/lang}</legend>

			<dl{if $errorField == 'jCoins'} class="formError"{/if}>
				<dt><label for="jCoins">{lang}wcf.acp.jcoins.premiumgroups.jCoins{/lang}</label></dt>
				<dd>
					<input type="number" id="jCoins" name="jCoins" value="{$jCoins}" required="required" autofocus="autofocus" class="medium" />
					{if $errorField == 'jCoins'}
						<small class="innerError">
							{if $errorType == 'underZero'}
								{lang}wcf.acp.jcoins.underzero{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>

			<dl{if $errorField == 'period'} class="formError"{/if}>
				<dt><label for="period">{lang}wcf.acp.jcoins.premiumgroups.period{/lang}</label></dt>
				<dd>
					<input type="number" id="period" name="period" value="{$period}" {if $action == 'edit'}readonly="readonly"{/if} class="medium" />
					{if $errorField == 'period'}
						<small class="innerError">
							{if $errorType == 'notValid'}
								{lang}wcf.acp.jcoins.period.invalid{/lang}
							{/if}
						</small>
					{/if}

                                        <small>{lang}wcf.acp.jcoins.premiumgroups.period.description{/lang}</small>
				</dd>
			</dl>

			<dl>
				<dt><label for="description">{lang}wcf.acp.jcoins.premiumgroups.description{/lang}</label></dt>
				<dd>
					<textarea cols="40" rows="10" name="description" id="description">{$i18nPlainValues['description']}</textarea>
				</dd>
			</dl>

			<dl{if $errorField == 'groupID'} class="formError"{/if}>
				<dt><label for="groupID">{lang}wcf.acp.jcoins.premiumgroups.groupID{/lang}</label></dt>
				<dd>
					{if $action == 'edit'}
				{if $premiumGroup->getGroup()->isEditable()}<a href="{link controller='UserGroupEdit' id=$premiumGroup->getGroup()->groupID}{/link}">{lang}{$premiumGroup->getGroup()}{/lang}</a>{else}{$premiumGroup->getGroup()}{/if}
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
	{@SECURITY_TOKEN_INPUT_TAG}
</div>
</form>

{include file='footer'}