<template>
	<tr>
		<td class="lite-gray">
			{{ actionName }}
		</td>
		<td class="lite-gray">
			{{ mat }}
		</td>
		<td class="lite-gray">
			{{ quantity }}
		</td>
		<td class="lite-gray">
			{{ date }}
		</td>
		<td class="lite-gray">
			<Actions>
				<ActionButton icon="icon-delete" @click="deleteAction(actionId)">
					Delete
				</ActionButton>
			</Actions>
		</td>
	</tr>
</template>

<script>
import Actions from '@nextcloud/vue/dist/Components/Actions'
import ActionButton from '@nextcloud/vue/dist/Components/ActionButton'

export default {
	name: 'TableContent',
	components: {
		Actions,
		ActionButton,
	},
	props: {
		actionId: {
			type: Number,
			default: 1,
		},
		actionName: {
			type: String,
			default: 'Admin',
		},
		mat: {
			type: String,
			default: 'Matite',
		},
		quantity: {
			type: String,
			default: '2',
		},
		// eslint-disable-next-line vue/require-default-prop
		date: {
			type: String,
		},
	},
	methods: {
		deleteAction(actionId) {
			this.$emit('delete', actionId)
		},
	},
}
</script>
<style scoped>
	tr {
		background: white;
		border-radius: 10px 10px 10px 10px;
		margin-top: 2%
	}
</style>
