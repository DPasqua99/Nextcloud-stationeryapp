<template>
	<ul>
		<ListItem
			:title="actionName"
			:bold="true"
			:force-display-actions="true"
			:details="date"
			:counter-number="quantity"
			counter-type="highlighted">
			<template #icon>
				<Avatar
					:size="44"
					:display-name="actionName" />
			</template>
			<template #subtitle>
				{{ mat }}
			</template>
			<template #counter>
				<CounterBubble>
					{{ quantity }}
				</CounterBubble>
			</template>
			<template #actions>
				<ActionButton icon="icon-delete" @click="deleteAction(actionId)">
					Delete
				</ActionButton>
			</template>
		</ListItem>
	</ul>
</template>

<script>
// import Actions from '@nextcloud/vue/dist/Components/Actions'
import ActionButton from '@nextcloud/vue/dist/Components/ActionButton'
import ListItem from '@nextcloud/vue/dist/Components/ListItem'
import CounterBubble from '@nextcloud/vue/dist/Components/CounterBubble'
import Avatar from '@nextcloud/vue/dist/Components/Avatar'

export default {
	name: 'TableContent',
	components: {
		// Actions,
		ActionButton,
		ListItem,
		CounterBubble,
		Avatar,
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
