<template>
	<AppNavigationItem title="Materiale" :allow-collapse="true" :open="true">
		<AppNavigationItem
			v-for="material in materials"
			:key="material.id"
			:title="material.name">
			<template #counter>
				<AppNavigationCounter slot="counter" :highlighted="true">
					{{ material.quantity }}
				</AppNavigationCounter>
			</template>
			<template #actions>
				<ActionButton icon="icon-edit" @click="setQuantity">
					Edit
				</ActionButton>
				<ActionButton icon="icon-delete" @click="removeMaterials(material.id)">
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
		removeMaterials(materialId) {
			alert(materialId)
			this.$emit('remove-material', materialId)
		},
		setQuantity() {
			this.$emit('set-quantity')
		},
	},
}
</script>
