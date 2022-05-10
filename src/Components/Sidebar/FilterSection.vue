<template>
	<AppNavigationItem title="Azioni">
		<AppNavigationItem class="active" title="Tutti" />
		<AppNavigationItem title="Oggi" />
		<AppNavigationItem title="Ultimi 7 giorni" />
		<AppNavigationItem title="Ultimo mese" />
	</AppNavigationItem>
</template>

<script>
import AppNavigationItem from '@nextcloud/vue/dist/Components/AppNavigationItem'

export default {
	name: 'FilterSection',
	components: {
		AppNavigationItem,
	},
}
</script>
