{include file='documentHeader'}

<head>
	<title>{lang}wcf.jcoins.premiumgroups.title{/lang} - {PAGE_TITLE|language}</title>
	
	{include file='headInclude'}
	<script type="text/javascript" src="{@$__wcf->getPath()}js/WCF.JCoins.js"></script>
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header'}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.jcoins.premiumgroups.title{/lang}</h1>
	</hgroup>
</header>

{include file='userNotice'}

	<div class="container containerPadding marginTop">
	    {hascontent}
	    {content}
	    {foreach from=$premiumGroups item=premiumGroup}
		{if !$premiumGroup->isDisabled || $premiumGroup->isMember()}
		<fieldset>
			<legend>{$premiumGroup->getGroup()}{if $premiumGroup->isMember()} <span class="badge green">{lang}wcf.jcoins.premiumgroups.active{/lang}</span>{/if}</legend>
			
			<dl>
				<dt>{lang}wcf.jcoins.premiumgroups.description{/lang}</dt>
				<dd>{$premiumGroup->description|language}</dd>
			</dl>
			
			<dl>
				<dt>{lang}wcf.jcoins.premiumgroups.costs{/lang}</dt>
				<dd>{#$premiumGroup->jCoins}</dd>
			</dl>
			
			<dl>
				<dt>{lang}wcf.jcoins.premiumgroups.period{/lang}</dt>
				<dd>{#$premiumGroup->period} {lang}wcf.jcoins.premiumgroups.day{if $premiumGroup->period > 1}s{/if}{/lang}</dd>
			</dl>
			
			{if !$premiumGroup->isDisabled}
			<dl>
				<dt>{lang}wcf.jcoins.premiumgroups.buy{/lang}</dt>
				<dd>{if $premiumGroup->jCoins > $__wcf->user->jCoinsBalance}<span class="badge red">{lang}wcf.jcoins.premiumgroups.notenougthjcoins{/lang}</span>{else}<span class="button" id="buyPremiumGroupButton{$premiumGroup->premiumGroupID}">{if $premiumGroup->isMember()}{lang}wcf.jcoins.premiumgroups.renew{/lang}{else}{lang}wcf.jcoins.premiumgroups.buy{/lang}{/if}{/if}</span></dd>
			</dl>
			    <script type="text/javascript">
				new WCF.JCoins.Buy({$premiumGroup->premiumGroupID});
			    </script>
			
			{/if}
			
		</fieldset>
		{/if}
		{/foreach}
		{event name='additionalPremiumGroups'}
		
		{/content}
		{hascontentelse}
		<p class="info">{lang}wcf.jcoins.premiumgroups.nogroups{/lang}</p>
		{/hascontent}
	</div>

{include file='footer'}

</body>
</html>