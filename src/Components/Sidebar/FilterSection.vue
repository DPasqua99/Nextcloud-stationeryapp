<template>
	<AppNavigationItem title="Azioni">
		<AppNavigationItem :class="{active: activeAll}" title="Tutti" @click="activeFilterAll" />
		<AppNavigationItem :class="{active: activeToday}" title="Oggi" @click="activeFilterToday" />
		<AppNavigationItem :class="{active: activeLastWeek}" title="Ultimi 7 giorni" @click="activeFilterLastWeek" />
		<AppNavigationItem :class="{active: activeLastMonth}" title="Ultimo mese" @click="activeFilterLastMonth" />
	</AppNavigationItem>
</template>

<script>
import AppNavigationItem from '@nextcloud/vue/dist/Components/AppNavigationItem'

export default {
	name: 'FilterSection',
	components: {
		AppNavigationItem,
	},
	data() {
		return {
			activeAll: false,
			activeToday: true,
			activeLastWeek: false,
			activeLastMonth: false,
		}
	},
	methods: {
		activeFilterAll() {
			this.activeAll = true
			this.activeToday = false
			this.activeLastWeek = false
			this.activeLastMonth = false
			this.$emits('filterAll')
		},
		activeFilterToday() {
			this.activeAll = false
			this.activeToday = true
			this.activeLastWeek = false
			this.activeLastMonth = false
			this.$emits('filterToday')
		},
		activeFilterLastWeek() {
			this.activeAll = false
			this.activeToday = false
			this.activeLastWeek = true
			this.activeLastMonth = false
			this.$emits('filterLastWeek')
		},
		activeFilterLastMonth() {
			this.activeAll = false
			this.activeToday = false
			this.activeLastWeek = false
			this.activeLastMonth = true
			this.$emits('filterLastMonth')
		},
	},
}
</script>
