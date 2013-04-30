{include file='documentHeader'}

<head>
	<title>{lang}wcf.jCoins.premiumgroups.title{/lang} - {PAGE_TITLE|language}</title>
	
	{include file='headInclude'}
	<script type="text/javascript" src="./wcf/js/WCF.JCoins.js"></script>
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header'}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.jCoins.premiumgroups.title{/lang}</h1>
	</hgroup>
</header>

{include file='userNotice'}

	<div class="container containerPadding marginTop">
	    {hascontent}
	    {content}
	    {foreach from=$pGroups item="group"}
		{if !$group->isDisabled() || $group->isMember()}
		<fieldset>
			<legend>{lang}{$group->getGroup()->getName()}{/lang}{if $group->isMember()} <span class="badge green">{lang}wcf.jCoins.premiumgroups.active{/lang}</span>{/if}</legend>
			
			<dl>
				<dt>{lang}wcf.jCoins.premiumgroups.description{/lang}</dt>
				<dd>{lang}{$group->getDescription()}{/lang}</dd>
			</dl>
			
			<dl>
				<dt>{lang}wcf.jCoins.premiumgroups.costs{/lang}</dt>
				<dd>{#$group->getJCoins()}</dd>
			</dl>
			
			<dl>
				<dt>{lang}wcf.jCoins.premiumgroups.period{/lang}</dt>
				<dd>{#$group->getPeriod()} {lang}wcf.jCoins.premiumgroups.day{if $group->getPeriod() > 1}s{/if}{/lang}</dd>
			</dl>
			
			{if !$group->isDisabled()}
			<dl>
				<dt>Kaufen</dt>
				<dd>{if $group->getJCoins() > $__wcf->user->jCoinsBalance}<span class="badge red">{lang}wcf.jCoins.premiumgroups.notenougthjcoins{/lang}</span>{else}<span class="button" id="buyPremiumGroupButton{$group->premiumGroupID}">{if $group->isMember()}{lang}wcf.jCoins.premiumgroups.renew{/lang}{else}{lang}wcf.jCoins.premiumgroups.buy{/lang}{/if}{/if}</span></dd>
			</dl>
			    <script type="text/javascript">
				new WCF.JCoins.Buy({$group->premiumGroupID});
			    </script>
			
			{/if}
			
		</fieldset>
		{/if}
		{/foreach}
		{event name='additionalPremiumGroups'}
		
		{/content}
		{hascontentelse}
		<p class="info">Derzeit kannst du keine Premiumgruppen kaufen und es ist auch keine Premiumgruppe bei dir aktiv.</p>
		{/hascontent}
	</div>

{include file='footer'}

</body>
</html>