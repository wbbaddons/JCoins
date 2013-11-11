{include file='documentHeader'}

<head>
	<title>{lang}wcf.jcoins.statement.title{/lang} - {PAGE_TITLE|language}</title>

	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">

	{include file='header'}

	<header class="boxHeadline">
		<h1>{lang}wcf.jcoins.statement.title{/lang}</h1>
	</header>

	{include file='userNotice'}

	<div class="contentNavigation">
		{pages print=true assign=pagesLinks controller='OwnCoinsStatement' link="pageNo=%dpageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}

		{hascontent}
		<nav>
			<ul id="jCoinsStatementButtonContainer" class="">
				{content}
			{if $objects|count > 1}<li><a class="button" href="{link controller='SumUpStatements'}{/link}" title="{link controller='SumUpStatements'}{/link}"><span>{lang}wcf.jcoins.statement.compress{/lang}</span></a></li>{/if}
				{event name='largeButtonsTop'}
				{/content}
		</ul>
	</nav>
	{/hascontent}
</div>

{hascontent}
<div class="container containerPadding marginTop shadow">
        <fieldset>
		<div class="tabularBox tabularBoxTitle marginTop">
			<table class="table">
				<thead>
					<tr>
						<th class="columnID{if $sortField == 'entryID'} active {@$sortOrder}{/if}"><a href="{link controller='OwnCoinsStatement'}pageNo={@$pageNo}&sortField=entryID&sortOrder={if $sortField == 'entryID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.jcoins.statement.id{/lang}</a></th>
						<th class="columnText{if $sortField == 'reason'} active {@$sortOrder}{/if}"><a href="{link controller='OwnCoinsStatement'}pageNo={@$pageNo}&sortField=reason&sortOrder={if $sortField == 'reason' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.jcoins.statement.reason{/lang}</a></th>
						<th class="columnText{if $sortField == 'executedUserID'} active {@$sortOrder}{/if}"><a href="{link controller='OwnCoinsStatement'}pageNo={@$pageNo}&sortField=executedUserID&sortOrder={if $sortField == 'executedUserID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.jcoins.statement.user{/lang}</a></th>
						<th class="columnSum{if $sortField == 'sum'} active {@$sortOrder}{/if}"><a href="{link controller='OwnCoinsStatement'}pageNo={@$pageNo}&sortField=sum&sortOrder={if $sortField == 'sum' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.jcoins.statement.sum{/lang}</a></th>
						<th class="columnDate{if $sortField == 'time'} active {@$sortOrder}{/if}"><a href="{link controller='OwnCoinsStatement'}pageNo={@$pageNo}&sortField=time&sortOrder={if $sortField == 'time' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.jcoins.statement.date{/lang}</a></th>
					</tr>
				</thead>
				<tbody>
					{content}
					{foreach from=$objects item=item}
						<tr class="statementTableRow">
							<td>{#$item->entryID}</td>
							<td>{if $item->link != ""}<a href="{$item->link}">{/if}{$item->reason|language}{if $item->link != ""}</a>{/if}</td>
							<td>{if $item->executedUserID == 0}{lang}wcf.jcoins.systemuser{/lang}{else}<a href="{link controller='User' object=$item->getExecutedUser()}{/link}">{$item->getExecutedUser()->username}</a>{/if}</td>
							<td>{if $item->sum > 0}<span class="badge green">+{#$item->sum}</span>{else}<span class="badge red">{#$item->sum}</span>{/if}</td>
							<td>{@$item->time|time}</td>
						</tr>
					{/foreach}
					{/content}
				</tbody>
			</table>
		</div>
        </fieldset>
</div>
{hascontentelse}
<p class="info">{lang}wcf.jcoins.statement.noresults{/lang}</p>
{/hascontent}

<div class="contentNavigation">
	{@$pagesLinks}

	{hascontent}
	<nav>
		<ul id="jCoinsStatementButtonContainer" class="">
			{content}
		{if $objects|count > 1}<li><a class="button" href="{link controller='SumUpStatements'}{/link}" title="{link controller='SumUpStatements'}{/link}"><span>{lang}wcf.jcoins.statement.compress{/lang}</span></a></li>{/if}

		{event name='largeButtonsBottom'}
		{/content}
	</ul>
</nav>
{/hascontent}
</div>

<div class="copyright"><a href="{link controller='JCoinsCredits'}{/link}">jCoins entwickelt von <strong>Joshua Rüsweg</strong></a></div>

{include file='footer'}

</body>
</html>