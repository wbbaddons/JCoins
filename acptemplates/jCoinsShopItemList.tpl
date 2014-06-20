{include file='header' pageTitle='wcf.acp.jcoins.shop.list'}

<script data-relocate="true">
	//<![CDATA[
	$(function() {
		new WCF.Action.Delete('wcf\\data\\user\\group\\premium\\UserGroupPremiumAction', '.jsNotice');
		new WCF.Action.Toggle('wcf\\data\\user\\group\\premium\\UserGroupPremiumAction', '.jsNotice');
		new WCF.Sortable.List('itemList', 'wcf\\data\\user\\group\\premium\\UserGroupPremiumAction', {@$startIndex});
	});
	//]]>
</script>

<header class="boxHeadline">
	<h1>{lang}wcf.acp.jcoins.shop.list{/lang}</h1>
</header>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="NoticeList" link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
	
	<nav>
		<ul>
			<li><a href="{link controller='JCoinsShopItemAdd'}{/link}" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.jcoins.shop.add{/lang}</span></a></li>
			
			{event name='contentNavigationButtonsTop'}
		</ul>
	</nav>
</div>

{if $objects|count}
	<div class="container containerPadding sortableListContainer marginTop"  id="itemList">
		<ol class="sortableList" data-object-id="0" start="{@($pageNo - 1) * $itemsPerPage + 1}">
			{foreach from=$objects item='item'}
				<li class="sortableNode sortableNoNesting jsNotice" data-object-id="{@$item->getObjectID()}">
					<span class="sortableNodeLabel">
						<a href="{link controller='JCoinsShopItemEdit' object=$item}{/link}">{$item->name}</a>
						
						<span class="statusDisplay sortableButtonContainer">
							<span class="icon icon16 icon-check{if $item->isDisabled}-empty{/if} jsToggleButton jsTooltip pointer" title="{lang}wcf.global.button.{if $item->isDisabled}enable{else}disable{/if}{/lang}" data-object-id="{$item->itemID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}"></span>
							<a href="{link controller='JCoinsShopItemEdit' object=$item}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 icon-pencil"></span></a>
							<span class="icon icon16 icon-remove jsDeleteButton jsTooltip pointer" title="{lang}wcf.global.button.delete{/lang}" data-object-id="{$item->itemID}" data-confirm-message="{lang}wcf.acp.delete.confirmMessage{/lang}"></span>
							
							{event name='itemButtons'}
						</span>
					</span>
				</li>
			{/foreach}
		</ol>
		
		<div class="formSubmit">
			<button class="button" data-type="submit">{lang}wcf.global.button.saveSorting{/lang}</button>
		</div>
	</div>
	
	<div class="contentNavigation">
		{@$pagesLinks}
		
		<nav>
			<ul>
			<li><a href="{link controller='JCoinsShopItemAdd'}{/link}" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.jcoins.shop.add{/lang}</span></a></li>
				
				{event name='contentNavigationButtonsBottom'}
			</ul>
		</nav>
	</div>
{else}
	<p class="info">{lang}wcf.global.noItems{/lang}</p>
{/if}

{include file='footer'}