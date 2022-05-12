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
				:action-id="action.id"
				:action-name="action.name"
				:mat="action.material"
				:quantity="action.quantity"
				:date="action.date"
				@delete="deleteAction" />
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
		// eslint-disable-next-line vue/require-default-prop
		actions: {
			type: Array,
		},
	},
	data() {
		return {
		}
	},
	methods: {
		deleteAction(id) {
			alert(id)
			this.$emit('delete', id)
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
