{include file='documentHeader'}

<head>
	<title>{lang}wcf.jcoins.copyright.title{/lang} - {PAGE_TITLE|language}</title>

	{include file='headInclude' sandbox=false}
</head>

<body id="tpl{$templateName|ucfirst}">
	{include file='header' sandbox=false}

	<header class="boxHeadline">
		<hgroup>
			<h1>{lang}wcf.jcoins.copyright.title{/lang}</h1>
		</hgroup>
	</header>

	{include file='userNotice'}

	<div class="marginTop jCoinsDev">
		<div class="container marginTop">
			<ol class="containerList doubleColumned userList">
				<li>
					<div class="jcoins">
						<div class="details userInformation">
							<hgroup class="containerHeadline">
								<h1>{lang}wcf.jcoins.title{/lang}</h1> 
								<h2>
									<ul class="dataList">
										<li>{lang}wcf.jcoins.copyright.from{/lang}</li>
										<li>{lang}wcf.jcoins.copyright.github{/lang}</li>
										<li>{lang}wcf.jcoins.copyright.with{/lang}</li>
									</ul>
								</h2>
							</hgroup>	
						</div>
					</div>
				</li>					
			</ol>
		</div>

		{event name='additionalPackages'}
	</div>

	{include file='footer' sandbox=false}
</body>
</html>