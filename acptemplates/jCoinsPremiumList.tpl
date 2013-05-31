{include file='header' pageTitle='wcf.acp.jcoins.premiumgroups.list'}

<header class="boxHeadline">
	<h1>{lang}wcf.acp.jcoins.premiumgroups.list{/lang}</h1>
	
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('wcf\\data\\user\\group\\premiumGroup\\PremiumGroupAction', '.jsBBCodeRow');
			new WCF.Action.Toggle('wcf\\data\\user\\group\\premiumGroup\\PremiumGroupAction', $('.jsBBCodeRow'));
		});
		//]]>
	</script>
</header>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="JCoinsPremiumList" link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
	{hascontent}
	<nav>
	    {content}
		    {if $canAddNewGroup}<ul><li><a href="{link controller='JCoinsPremiumAdd'}{/link}" title="" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.jcoins.premiumgroups.add{/lang}</span></a></li></ul>{/if}
		    {event name='additonalNavigationLinks'}
	    {/content}
	</nav>
	{/hascontent}
</div>

{hascontent}
	<div class="tabularBox tabularBoxTitle marginTop">
		<header>
			<h2>{lang}wcf.acp.jcoins.premiumgroups.list{/lang} <span class="badge badgeInverse">{#$items}</span></h2>
		</header>
		
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnPremiumGroupID{if $sortField == 'premiumGroupID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='JCoinsPremiumList'}pageNo={@$pageNo}&sortField=bbcodeID&sortOrder={if $sortField == 'premiumGroupID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
					<th class="columnTitle columnGroupName">Gruppe</th>
					<th class="columnInteger columnJCoins{if $sortField == 'jCoins'} active {@$sortOrder}{/if}"><a href="{link controller='JCoinsPremiumList'}pageNo={@$pageNo}&sortField=jCoins&sortOrder={if $sortField == 'jCoins' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.jcoins.premiumgroups.jcoins{/lang}</a></th>
					<th class="columnInteger columnPeriod{if $sortField == 'period'} active {@$sortOrder}{/if}"><a href="{link controller='JCoinsPremiumList'}pageNo={@$pageNo}&sortField=period&sortOrder={if $sortField == 'period' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.jcoins.premiumgroups.period{/lang}</a></th>
					<th class="columnInteger columnMembers{if $sortField == 'members'} active {@$sortOrder}{/if}"><a href="{link controller='JCoinsPremiumList'}pageNo={@$pageNo}&sortField=members&sortOrder={if $sortField == 'members' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.jcoins.premiumgroups.members{/lang}</a></th>

					{event name='headColumns'}
				</tr>
			</thead>
			
			<tbody>
				{content}
					{foreach from=$objects item=group}
						<tr class="jsBBCodeRow">
							<td class="columnIcon">
							    <span class="icon icon16 icon-{if $group->isDisabled}off{else}circle-blank{/if}{if !$group->isAccessible()} disabled{else} jsToggleButton jsTooltip pointer{/if}" {if $group->isAccessible()}title="{lang}wcf.global.button.{if $group->isDisabled}enable{else}disable{/if}{/lang}" data-object-id="{@$group->premiumGroupID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}"{/if}></span>
							    
							    {if $group->isAccessible()}<a href="{link controller='JCoinsPremiumEdit' object=$group}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip">{/if}<span class="icon icon16 icon-pencil{if !$group->isAccessible()} disabled{/if}"></span>{if $group->isAccessible()}</a>{/if}
								
							    <span class="icon icon16 icon-remove {if !$group->isDeletable() || !$group->isAccessible()}disabled{else}jsDeleteButton jsTooltip{/if}" data-object-id="{@$group->premiumGroupID}" title="{lang}wcf.global.button.delete{/lang}"></span>
								
							    
							    
								{event name='buttons'}
							</td>
							<td class="columnID"><p>{@$group->premiumGroupID}</p></td>
							<td class="columnTitle columnGroupName"><p>{if $group->getGroup()->isEditable()}<a href="{link controller='UserGroupEdit' id=$group->groupID}{/link}">{lang}{$group->getGroup()}{/lang}</a>{else}{$group->getGroup()}{/if}</p></td>
							<td class="columnText columnJCoins"><p>{#$group->jCoins}</p></td>
							<td class="columnText columnPeriod"><p>{#$group->period} Tage</p></td>
							<td class="columnInteger columnActiveMember"><p>{#$group->members}</p></td>
							
							{event name='columns'}
						</tr>
					{/foreach}
				{/content}
			</tbody>
		</table>
		
	</div>
    {hascontentelse}
	<p class="info">{lang}wcf.acp.jcoins.premiumgroups.nogroups{/lang}</p>
{/hascontent}
	
	<div class="contentNavigation">
		{@$pagesLinks}
		
		{hascontent}
		<nav>
		    {content}
			    {if $canAddNewGroup}<ul><li><a href="{link controller='JCoinsPremiumAdd'}{/link}" title="" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.jcoins.premiumgroups.add{/lang}</span></a></li></ul>{/if}
			    {event name='additonalNavigationLinks'}
		    {/content}
		</nav>
		{/hascontent}
	
	</div>

{include file='footer'}