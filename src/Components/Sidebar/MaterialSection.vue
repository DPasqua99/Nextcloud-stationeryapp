<template>
	<AppNavigationItem title="Materiale" icon="icon-category-enabled">
		<AppNavigationItem
			v-for="material in materials"
			:key="material.id"
			:title="material.name">
			<AppNavigationCounter slot="counter" :highlighted="true">
				{{ material.quantity }}
			</AppNavigationCounter>
			<template #actions>
				<ActionButton icon="icon-edit" @click="alert('Edit')">
					Edit
				</ActionButton>
				<ActionButton icon="icon-delete" @click="alert('Delete')">
					Delete
				</ActionButton>
			</template>
		</AppNavigationItem>
		<AppNavigationNewItem title="Aggiungi Materiale" icon="icon-add" @new-item="addMaterials" />
	</AppNavigationItem>
</template>

<script>
import AppNavigationItem from '@nextcloud/vue/dist/Components/AppNavigationItem'
import AppNavigationCounter from '@nextcloud/vue/dist/Components/AppNavigationCounter'
import AppNavigationNewItem from '@nextcloud/vue/dist/Components/AppNavigationNewItem'
import ActionButton from '@nextcloud/vue/dist/Components/ActionButton'
import { emit } from '@nextcloud/event-bus'
emit('toggle-navigation', {
	open: true,
})
emit('toggle-navigation', {
	open: false,
})

export default {
	name: 'MaterialSection',
	components: {
		AppNavigationItem,
		AppNavigationCounter,
		AppNavigationNewItem,
		ActionButton,

	},
	props: {
		materials: {
			type: Array,
			default: null,
		},
	},
	data() {
	},
	methods: {
		addMaterials(value) {
			this.$emit('new-item', value)
		},
	},
}
</script>
