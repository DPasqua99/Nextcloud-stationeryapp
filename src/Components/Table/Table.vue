<template>
	<table>
		<thead>
			<tr>
				<th class="short-column">
					Nome
				</th>
				<th class="short-column">
					Materiale
				</th>
				<th class="short-column">
					Quantit&agrave;
				</th>
				<th class="short-column">
					Data e Ora
				</th>
			</tr>
		</thead>
		<tbody>
			<TableContent
				v-for="action in actions"
				:key="action.id"
				:actionId="action.id"
				:actionName="action.actionName"
				:mat="action.mat"
				:quantity="action.quantity"
				:date="action.date"
				@clicked="deleteAction(action)" />
		</tbody>
	</table>
</template>

<script>
import TableContent from './TableContent.vue'

export default {
	name: 'Table',
	components: {
		TableContent,
	},
	props: {
		actions: {
			type: Array,
			default: null,
		},
	},
	data() {
		return {
		}
	},
	methods: {
		deleteAction(action) {
			this.$emit('clicked', action)
		},
	},
}
</script>

<style scoped>
	table {
		margin: 0px 0;
		border-collapse: separate;
		margin-left: 50px;
		table-layout: fixed;
		width: 100%;
	}

	th {
		font-size: 20px;
		font-weight: bold;
	}
</style>
