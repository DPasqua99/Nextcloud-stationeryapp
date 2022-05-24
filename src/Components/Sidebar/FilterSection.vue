<template>
	<AppNavigationItem title="Azioni" class="bottom">
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
			activeAll: true,
			activeToday: false,
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
			this.$emit('filter-all')
		},
		activeFilterToday() {
			this.activeAll = false
			this.activeToday = true
			this.activeLastWeek = false
			this.activeLastMonth = false
			this.$emit('filter-today')
		},
		activeFilterLastWeek() {
			this.activeAll = false
			this.activeToday = false
			this.activeLastWeek = true
			this.activeLastMonth = false
			this.$emit('filter-last-week')
		},
		activeFilterLastMonth() {
			this.activeAll = false
			this.activeToday = false
			this.activeLastWeek = false
			this.activeLastMonth = true
			this.$emit('filter-last-month')
		},
	},
}
</script>

<style scoped>
	.bottom{
		position: fixed;
		bottom: 1%;
		overflow: hidden;
	}
</style>
