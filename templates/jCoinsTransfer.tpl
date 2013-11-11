{include file="documentHeader"}

<head>
	<title>{lang}wcf.jcoins.transfer{/lang} - {PAGE_TITLE|language}</title>

	{include file='headInclude'}
</head>

<body id="tpl{$templateName|ucfirst}">

	{include file='header'}

	<header class="boxHeadline">
		<h1>{lang}wcf.jcoins.transfer{/lang}</h1>
	</header>

	{include file='userNotice'}

	{if $errorField}
		<p class="error">{lang}wcf.global.form.error{/lang}</p>
	{/if}

	{if $success}
		<p class="success">{lang}wcf.global.success.add{/lang}</p>
	{/if}

	<form method="post" action="{link controller='JCoinsTransfer'}{/link}">
		<div class="container containerPadding marginTop">
			<fieldset>
				<legend>{lang}wcf.jcoins.transfer.general{/lang}</legend>

				<dl id="usernameDiv"{if $errorField == 'username'} class="formError"{/if}>
					<dt>
					<label for="usernameInput">{lang}wcf.user.username{/lang}</label>
					</dt>
					<dd>
						<input type="text" id="usernameInput" name="username" value="{foreach from=$user item=$cUser}{$cUser->username}, {/foreach}" class="medium" />
						{if $errorField == 'username'}
							<small class="innerError">
							{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{/if}
						{if $errorType == 'notFound'}{lang}wcf.user.error.username.notFound{/lang}{/if}
					{if $errorType == 'isIgnored'}Der User {$ignoredUsername} ignoriert dich leider...{/if}
				</small>
			{/if}
		</dd>
	</dl>

	<script data-relocate="true">
		new WCF.Search.User('#usernameInput', null, false, null, true);
	</script>

	<dl id="sumDiv"{if $errorField == 'sum'} class="formError"{/if}>
		<dt>
		<label for="sumInput">{lang}wcf.jcoins.statement.sum{/lang}</label>
		</dt>
		<dd>
			<input type="number" id="sumInput" name="sum" value="{$sum}" class="medium" />
			{if $errorField == 'sum'}
				<small class="innerError">
				{if $errorType == 'tooMuch'}{lang}wcf.jcoins.transfer.error.toomuch{/lang}{/if}
			{if $errorType == 'tooLess'}{lang}wcf.jcoins.transfer.error.tooless{/lang}{/if}
		</small>
	{/if}
</dd>
</dl>

<dl id="reasonDiv"{if $errorField == 'reson'} class="formError"{/if}>
	<dt>
	<label for="reasonInput">{lang}wcf.jcoins.statement.reason{/lang}</label>
	</dt>
	<dd>
		<input type="text" id="reasonInput" name="reason" value="{$reason}" class="medium" />
		{if $errorField == 'reason'}
			<small class="innerError">
			{if $errorType == 'tooShort'}{lang}wcf.jcoins.transfer.error.tooshort{/lang}{/if}
		{if $errorType == 'tooLong'}{lang}wcf.jcoins.transfer.error.toolong{/lang}{/if}
	</small>
{/if}
</dd>
</dl>
{if $__wcf->session->getPermission('mod.jcoins.canModTransfer')}
	<dl id="isModTransferDiv">
		<dd>
			<label>
				<input type="checkbox" name="isModerativ" id="isModerativ" value="1">
				{lang}wcf.jcoins.transfer.domoderativ{/lang}
			</label>
		</dd>
	</dl>
{/if}
</fieldset>
</div>

<div class="formSubmit">
	<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
	{@SECURITY_TOKEN_INPUT_TAG}
</div>
</form>

<div class="copyright"><a href="{link controller='JCoinsCredits'}{/link}">jCoins entwickelt von <strong>Joshua Rüsweg</strong></a></div>

{include file='footer'}

</body>
</html>
