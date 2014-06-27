{include file='documentHeader'}

<head>
	<title>{lang}wcf.jcoins.shop{/lang} - {PAGE_TITLE|language}</title>

	{include file='headInclude'}
	<script data-relocate="true" type="text/javascript" src="{@$__wcf->getPath()}js/WCF.JCoins{if !ENABLE_DEBUG_MODE}.min{/if}.js"></script>
        <script data-relocate="true" type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.JCoins.Shop.Buy($('.jCoinsShopItemButtons > li'));
		});
		//]]>
        </script>
</head>

<body id="tpl{$templateName|ucfirst}">
	{include file='header'}

	<header class="boxHeadline">
		<h1>{lang}wcf.jcoins.shop{/lang}</h1>
	</header>

	{include file='userNotice'}

	{if $items}
		<div class="container marginTop">
			<ul class="containerList jCoinsShopItems">
				{foreach from=$items item=item}
					<li>
						<div class="clearfix">
							<div>
								<div class="containerHeadline">
									<h3>{lang}{$item->name}{/lang} <span class="badge green">{#$item->price} {lang}wcf.jcoins.title{/lang}</span></h3>
								</div>
								<p>{lang}{$item->description}{/lang}</p>
								<ul class="buttonList smallButtons marginTop jCoinsShopItemButtons" style="float: right;">
									{if $item->isMultiple() || !$item->hasBought()}
										<li><button {if !$item->canBuy()}disabled="disabled" {/if}class="buttonPrimary small buttonBuy" data-item-id="{$item->getObjectID()}">{lang}wcf.jcoins.shop.buy{/lang}</button></li>
									{else}
										<li><button class="small buttonPrimary buttonBought" data-item-id="{$item->getObjectID()}">{lang}wcf.jcoins.shop.bought{/lang}</button></li>
									{/if}
								</ul>
							</div>
						</div>
					</li>
				{/foreach}
			</ul>
		</div>
	{else}
		<p class="error">{lang}wcf.jcoins.shop.noitems{/lang}</p>	
	{/if}
	
	{include file='footer'}

</body>
</html>
