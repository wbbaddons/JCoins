{include file='documentHeader'}

<head>
	<title>{lang}wcf.jcoins.globalactivity.title{/lang} - {PAGE_TITLE|language}</title>

	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">

	{include file='header' sandbox=false}

	<header class="boxHeadline">
		<h1>{lang}wcf.jcoins.globalactivity.title{/lang}</h1>
	</header>

	{include file='userNotice'}

	<div class="contentNavigation">
		{pages print=true assign=pagesLinks controller='JCoinsGlobalActivity' link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}

		{hascontent}
		<nav>
			<ul id="jCoinsStatementButtonContainer">
				{content}
				{event name='largeButtonsTop'}
				{/content}
			</ul>
		</nav>
		{/hascontent}
	</div>

	<div class="marginTop statementBox">
		{if $objects|count == 0}
			<p class="info">{lang}wcf.jcoins.globalactivity.noresults{/lang}</p>
		{else}
			<div class="tabularBox tabularBoxTitle marginTop">
			<table class="table">
				<thead>
					<tr>
						<th class="columnID{if $sortField == 'entryID'} active {@$sortOrder}{/if}"><a href="{link controller='JCoinsGlobalActivity'}pageNo={@$pageNo}&sortField=entryID&sortOrder={if $sortField == 'entryID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.jcoins.statement.id{/lang}</a></th>
						<th class="columnText{if $sortField == 'userID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='JCoinsGlobalActivity'}pageNo={@$pageNo}&sortField=userID&sortOrder={if $sortField == 'userID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.jcoins.statement.reciveuser{/lang}</a></th>
						<th class="columnText{if $sortField == 'reason'} active {@$sortOrder}{/if}"><a href="{link controller='JCoinsGlobalActivity'}pageNo={@$pageNo}&sortField=reason&sortOrder={if $sortField == 'reason' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.jcoins.statement.reason{/lang}</a></th>
						<th class="columnText{if $sortField == 'executedUserID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='JCoinsGlobalActivity'}pageNo={@$pageNo}&sortField=executedUserID&sortOrder={if $sortField == 'executedUserID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.jcoins.statement.user{/lang}</a></th>
						<th class="columnSum{if $sortField == 'sum'} active {@$sortOrder}{/if}"><a href="{link controller='JCoinsGlobalActivity'}pageNo={@$pageNo}&sortField=sum&sortOrder={if $sortField == 'sum' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.jcoins.statement.sum{/lang}</a></th>
						<th class="columnDate{if $sortField == 'time'} active {@$sortOrder}{/if}"><a href="{link controller='JCoinsGlobalActivity'}pageNo={@$pageNo}&sortField=time&sortOrder={if $sortField == 'time' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.jcoins.statement.date{/lang}</a></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$objects item=item}
						<tr class="statementTableRow">
							<td>{#$item->entryID}{if $item->isTrashed} <span class="icon icon16 icon-trash"></span>{/if}{if $item->isModTransfer} <span class="badge green">{lang}wcf.jcoins.transfer.moderativDisplay{/lang}</span>{/if}</td>
							<td class="columnIcon columnAvatar">
								{if $item->getUser() && $item->getUser()->getAvatar()}
									<div>
										<p class="framed">{@$item->getUser()->getAvatar()->getImageTag(32)}</p>
									</div>
								{/if}
							</td>
							<td>{if $item->userID == 0}{lang}wcf.jcoins.systemuser{/lang}{else}<a href="{link controller='User' object=$item->getUser()}{/link}">{$item->getUser()->username}</a>{/if}</td>
							<td>{if $item->link != ""}<a href="{$item->link}">{/if}{$item->getReason()}{if $item->link != ""}</a>{/if}</td>
							<td class="columnIcon columnAvatar">
								{if $item->getExecutedUser() && $item->getExecutedUser()->getAvatar()}
									<div>
										<p class="framed">{@$item->getExecutedUser()->getAvatar()->getImageTag(32)}</p>
									</div>
								{/if}
							</td>
							<td>{if $item->executedUserID == 0}{lang}wcf.jcoins.systemuser{/lang}{else}<a href="{link controller='User' object=$item->getExecutedUser()}{/link}">{$item->getExecutedUser()->username}</a>{/if}</td>
							<td>{if $item->sum > 0}<span class="badge green">+{#$item->sum}</span>{else}<span class="badge red">{#$item->sum}</span>{/if}</td>
							<td>{@$item->time|time}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
				</div>
		{/if}
	</div>

	<div class="contentNavigation">
		{@$pagesLinks}

		{hascontent}
		<nav>
			<ul id="jCoinsStatementButtonContainer">
				{content}
				{event name='largeButtonsBottom'}
				{/content}
			</ul>
		</nav>
		{/hascontent}
	</div>

	{include file='footer'}

</body>
</html>