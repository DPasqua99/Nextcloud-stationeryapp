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
		},
		actionName: {
			type: String,
			default: 'Admin',
		},
		mat: {
			type: String,
			default: 'Penne',
		},
		quantity: {
			type: Number,
			default: 1,
		},
		date: {
			type: String,
		},
	},
	methods: {
		deleteAction(actionId) {
			this.$emit('clicked', actionId)
		},
	},
}
</script>
