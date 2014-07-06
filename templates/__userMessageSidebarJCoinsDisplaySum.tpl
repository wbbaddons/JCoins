{if MODULE_JCOINS && $__wcf->session->getPermission('user.jcoins.canSee')}
	<dt>{lang}wcf.jcoins.title{/lang}</dt>
	<dd>{#$userProfile->jCoinsBalance}</dd>
{/if}